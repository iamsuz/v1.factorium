pragma solidity ^0.5.12;

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

contract SmartInvoice {

    enum Status { UNCOMMITTED, COMMITTED, BOUGHT, SETTLED }
    function getStatusString(Status status)
    public
    pure
    returns (string memory)
    {
        if (Status.UNCOMMITTED == status) {
            return 'UNCOMMITTED';
        }
        if (Status.COMMITTED == status) {
            return 'COMMITTED';
        }
        if(Status.BOUGHT == status){
            return 'BOUGHT';
        }
        if (Status.SETTLED == status) {
            return 'SETTLED';
        }
        return 'ERROR';
    }
    uint256 private amount;
    uint256 private totalSupply;
    string public symbol = 'INV';
    uint8 public decimals = 18;
    uint256 public dueDate;
    uint256 public askingPrice;
    IERC20 public assetToken;
    address public seller;
    address public payer;
    string public referenceHash;
    mapping(address => uint256) public balanceOf;

    Status  public status;
    status = Status.UNCOMMITTED;
    /**
     * @dev Constructor that gives msg.sender all of existing tokens.
     * _amount is the paramenter for to keep the track of tokens
     * _askingPrice is the seller requesting amount
     * _dueDate is the Invoice has to settle before the dueDate or buyer will get penalised
     * _seller the one who creates the smart Invoice
     * _payer the wallet for which the smart invoice is created (Buyer)
     */
    // constructor(uint256 _amount,
    //             uint256 _askingPrice,
    //             uint256 _dueDate,
    //             address _seller,
    //             address _payer,
    //             string memory _referenceHash) public {
    //     require(_seller != address(0), 'seller cannot be 0x0');
    //     require(_payer != address(0), 'payer cannot be 0x0');
    //     require(_amount > 0, 'amount cannot be 0');
    //     require(_askingPrice < _amount, 'asking price cannot be greter than amount');
    //     require(_seller == msg.sender, 'Only seller can create this invoice');
    //     totalSupply = _amount;
    //     amount = _amount;
    //     askingPrice = _askingPrice;
    //     dueDate = _dueDate;
    //     seller = _seller;
    //     payer = _payer;
    //     referenceHash = _referenceHash;

    //     status = Status.UNCOMMITTED;
    // }

    //changeSeller function change sthe seller address
    //_newSeller is the new seller wallet address

    function changeSeller(address _newSeller) public returns (bool) {
        require(msg.sender == seller, 'caller not current seller');
        require(_newSeller != address(0), 'new seller cannot be 0x0');
        require(status != Status.SETTLED, 'can not change seller after settlement');
        seller = _newSeller;
        return true;
    }

    //commit is the function where payer will accept the smart invoice

    function commit() public returns (bool) {
        require(msg.sender == payer, 'only payer can commit');
        require(status == Status.UNCOMMITTED, 'can only commit while status in UNCOMMITTED');
        status = Status.COMMITTED;
        return true;
    }

    //buyInvoice is a function where any wallet address (financier) will buy the invoice with the total amount
    // you cannot by partial invoice the wallet has to buy the full invoice

    function buyInvoice() external payable returns (bool) {
        require(totalSupply > 0);
        require(status != Status.BOUGHT, 'already bought');
        require(msg.value >= askingPrice,'asking price needs to be available as ether and it should be equal or greated than asking amount');
        balanceOf[msg.sender] += totalSupply;
        totalSupply = 0;
        seller.call.value(msg.value)('Transferred ether to seller');
        status = Status.BOUGHT;
        return true;
    }

    //settle is a function where the payer (Buyer) will pay the money to the invoice
    //only payer wallet address can be invoke this function
    //use https://www.epochconverter.com/ for the now time

    function settle() public payable returns (bool) {
        require(msg.sender == payer, 'only payer can settle');
        //we have to add a functionality where if user is past the due date then payer should get penalised
        require(status == Status.BOUGHT, 'Not bought by anyone, cannot settle');
        require(status != Status.SETTLED, 'already settled');
        require(msg.value >= amount);
        balanceOf[address(this)] += msg.value;
        status = Status.SETTLED;
        return true;
    }

    //reddemInvTokens is a functionality where financier will return the INV tokens to smart contract and he will get the payment back

    function redeemInvTokens(uint256 _amount) public returns(bool){
        //This has not figured out how to ask for INV tokens or how to check the tokens are created from the same smart contract address;
        require(balanceOf[msg.sender] <= amount);
        require(status == Status.SETTLED, 'Not settled buy payer');
        balanceOf[msg.sender] -= _amount;
        msg.sender.call.value(address(this).balance - (address(this).balance - _amount))('Transferred ether to financier');
        return true;
    }
}
