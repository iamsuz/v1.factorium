pragma solidity ^0.4.24;

/**
 * Open Zeppelin ERC20 implementation. https://github.com/OpenZeppelin/openzeppelin-solidity/tree/master/contracts/token/ERC20
 */

/**
 * @dev Interface of the ERC20 standard as defined in the EIP. Does not include
 * the optional functions; to access them see `ERC20Detailed`.
 */
interface IERC20 {
    /**
     * @dev Returns the amount of tokens in existence.
     */
    function totalSupply() external view returns (uint256);

    /**
     * @dev Returns the amount of tokens owned by `account`.
     */
    function balanceOf(address account) external view returns (uint256);

    /**
     * @dev Moves `amount` tokens from the caller's account to `recipient`.
     *
     * Returns a boolean value indicating whether the operation succeeded.
     *
     * Emits a `Transfer` event.
     */
    function transfer(address recipient, uint256 amount) external returns (bool);

    /**
     * @dev Returns the remaining number of tokens that `spender` will be
     * allowed to spend on behalf of `owner` through `transferFrom`. This is
     * zero by default.
     *
     * This value changes when `approve` or `transferFrom` are called.
     */
    function allowance(address owner, address spender) external view returns (uint256);

    /**
     * @dev Sets `amount` as the allowance of `spender` over the caller's tokens.
     *
     * Returns a boolean value indicating whether the operation succeeded.
     *
     * > Beware that changing an allowance with this method brings the risk
     * that someone may use both the old and the new allowance by unfortunate
     * transaction ordering. One possible solution to mitigate this race
     * condition is to first reduce the spender's allowance to 0 and set the
     * desired value afterwards:
     * https://github.com/ethereum/EIPs/issues/20#issuecomment-263524729
     *
     * Emits an `Approval` event.
     */
    function approve(address spender, uint256 amount) external returns (bool);

    /**
     * @dev Moves `amount` tokens from `sender` to `recipient` using the
     * allowance mechanism. `amount` is then deducted from the caller's
     * allowance.
     *
     * Returns a boolean value indicating whether the operation succeeded.
     *
     * Emits a `Transfer` event.
     */
    function transferFrom(address sender, address recipient, uint256 amount) external returns (bool);

    /**
     * @dev Emitted when `value` tokens are moved from one account (`from`) to
     * another (`to`).
     *
     * Note that `value` may be zero.
     */
    event Transfer(address indexed from, address indexed to, uint256 value);

    /**
     * @dev Emitted when the allowance of a `spender` for an `owner` is set by
     * a call to `approve`. `value` is the new allowance.
     */
    event Approval(address indexed owner, address indexed spender, uint256 value);
}

contract SafeMath {
    function safeAdd(uint a, uint b) internal pure returns (uint c) {
        c = a + b;
        require(c >= a);
    }
    function safeSub(uint a, uint b) internal pure returns (uint c) {
        require(b <= a);
        c = a - b;
    }
    function safeMul(uint a, uint b) internal pure returns (uint c) {
        c = a * b;
        require(a == 0 || c / a == b);
    }
    function safeDiv(uint a, uint b) internal pure returns (uint c) {
        require(b > 0);
        c = a / b;
    }
}

contract SmartInvoice is SafeMath{

    enum Status { UNCOMMITTED, COMMITTED, BOUGHT, SETTLED }
    function getStatusString(Status status)
    public
    pure
    returns (string memory)
    {
        if (Status.UNCOMMITTED == status) {
            return "UNCOMMITTED";
        }
        if (Status.COMMITTED == status) {
            return "COMMITTED";
        }
        if(Status.BOUGHT == status){
            return "BOUGHT";
        }
        if (Status.SETTLED == status) {
            return "SETTLED";
        }
        return "ERROR";
    }
    uint256 public totalSupply;
    string public symbol;
    uint8 public decimals;
    uint256 public dueDate;
    uint256 public askingPrice;
    address public admin;
    address public seller;
    address public payer;
    uint256 private date;
    IERC20 public daiAddr;
    mapping(address => uint256) public balanceOf;
    mapping(address => mapping(address => uint256)) public allowance;

    Status  public status;

    event Transfer(
        address indexed _from,
        address indexed _to,
        uint256 _value
        );
    event Approval(
        address indexed _owner,
        address indexed _spender,
        uint256 _value
        );
    event Burn(address indexed burner, uint256 value);

    /**
     * @dev Constructor that gives msg.sender all of existing tokens.
     * _amount is the paramenter for to keep the track of tokens
     * _askingPrice is the seller requesting amount
     * _dueDate is the Invoice has to settle before the dueDate or buyer will get penalised
     * _seller the one who creates the smart Invoice
     * _payer the wallet for which the smart invoice is created (Buyer)
     */
    constructor(uint256 _amount,
                uint256 _askingPrice,
                uint256 _dueDate,
                address _payer,
                IERC20 _daiAddr,
                string _symbol) public {
        require(_payer != address(0), "payer cannot be 0x0");
        require(_amount > 0, "amount cannot be 0");
        require(_askingPrice < _amount, "asking price cannot be greter than amount");
        totalSupply = _amount;
        decimals = 18;
        askingPrice = _askingPrice;
        dueDate = _dueDate;
        seller = msg.sender;
        payer = _payer;
        require(seller != _payer,"seller cannot be payer");
        daiAddr = _daiAddr;
        symbol = _symbol;
        status = Status.UNCOMMITTED;
    }

    modifier getAskingPrice() {
        updateAskingPrice();
        _;
    }

    function updateAskingPrice() public returns(uint256){
        /** Due date must be in seconds **/
        require(dueDate >= now,"Due date has been passed");
        uint256 dateDiff = (dueDate - now) / 86400;
        askingPrice = safeDiv(safeMul(totalSupply, safeSub(6000, safeMul(5,dateDiff))),6000);
        return askingPrice;
    }


    function changeSeller(address _newSeller) public returns (bool) {
        require(msg.sender == seller, "caller not current seller");
        require(_newSeller != address(0), "new seller cannot be 0x0");
        require(status != Status.SETTLED, "can not change seller after settlement");
        require(status != Status.COMMITTED, "Can not change seller after committed from buyer");
        require(status != Status.BOUGHT, "Can not change seller after buying invoice");
        seller = _newSeller;
        return true;
    }


    function commit() public returns (bool) {
        require(msg.sender == payer, "only payer can commit");
        require(status == Status.UNCOMMITTED, "can only commit while status in UNCOMMITTED");
        status = Status.COMMITTED;
        balanceOf[seller] = safeAdd(balanceOf[seller],totalSupply);
        return true;
    }

    function buyInvoice(uint256 _dai) public getAskingPrice returns (bool) {
        require(status != Status.BOUGHT, "already bought");
        require(_dai >= askingPrice,"DAI should be equal or greated than asking price");
        require(balanceOf[seller] == totalSupply);
        status = Status.BOUGHT;
        balanceOf[seller] = safeSub(balanceOf[seller],totalSupply);
        balanceOf[msg.sender] = safeAdd(balanceOf[msg.sender],totalSupply);
        emit Transfer(seller, msg.sender, totalSupply);
        require(daiAddr.transferFrom(msg.sender, seller, _dai));
        return true;
    }

    function settle() public returns (bool) {
        require(msg.sender == payer, "only payer can settle");
        require(status != Status.SETTLED, "already settled");
        status = Status.SETTLED;
        emit Transfer(msg.sender, address(this), totalSupply);
        require(daiAddr.transferFrom(msg.sender, address(this), totalSupply));
        return true;
    }

    function redeemInvTokens(uint256 _amount) public returns(bool){
        require(balanceOf[msg.sender] <= totalSupply);
        require(status == Status.SETTLED, "Not settled by payer");
        _burn(msg.sender,_amount);
        require(daiAddr.transferFrom(address(this),msg.sender,_amount));
        return true;
    }

    function _burn(address _who, uint256 _value) internal {
        require(_value <= balanceOf[_who]);
        balanceOf[_who] = safeSub(balanceOf[_who],_value);
        emit Burn(_who, _value);
        emit Transfer(_who, address(0), _value);
  }
}
