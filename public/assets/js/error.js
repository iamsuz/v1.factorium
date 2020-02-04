function userInvoiceError() {
	$('.loader-overlay').hide();
	$('#alertBuyerInv').removeClass('hide');
	$('.invoiceConfirmationModal').modal('hide');
}
function loaderOverlay() {
	$('.loader-overlay').show();
	$('.overlay-loader-image').after('<div class="text-center alert alert-info"><h3>It may take a while!</h3><p>Please wait... your request is processed. Please do not refresh or reload the page.</p><br></div>');
}
