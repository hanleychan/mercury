<?php

require_once('MercuryHCClient.php');

function mercury_HC_client( $merchant_id, $merchant_password ) {
   $hc = new MercuryHCClient( $merchant_id, $merchant_password );
   return $hc;
}

function cardInfoIFrameURL( $hcws, $card_id ) {
   return $hcws->buildCardInfoIFrameURL( $card_id );
}

function paymentIFrameURL( $hcws, $payment_id ) {
   return $hcws->buildPaymentIFrameURL( $payment_id );
}

function initPayment( $hcws, $params ) {
   $response = $hcws->sendInitializePayment( $params );
   return $response;
}

function verifyPayment( $hcws, $payment_id ) {
   $response = $hcws->sendVerifyPayment(array(
      'PaymentID' => $payment_id
   ));

   return $response;
}

function initCardInfo( $hcws, $params ) {
    $response = $hcws->sendInitializeCardInfo( $params );
    return $response;
}

function verifyCardInfo( $hcws, $card_id ) {
   $response = $hcws->sendVerifyCardInfo(array(
      'CardID' => $card_id
   ));

   return $response;
}

function uploadCSS( $hcws, $css ) {
   $response = $hcws->sendUploadCSS(array(
      'Css' => $css
   ));

   return $response;
}

function downloadCSS( $hcws ) {
   $response = $hcws->sendDownloadCSS(array(
      'Formatting' => 'on'
   ));

   return $response;
}

function removeCSS( $hcws ) {
   $response = $hcws->sendRemoveCSS(array());
   return $response;
}

function creditPreAuthToken( $hcws, $params ) {
   $response = $hcws->sendCreditPreAuthToken( $params );
   return $response;
}

function creditPreAuthCaptureToken( $hcws, $params ) {
   $response = $hcws->sendCreditPreAuthCaptureToken( $params );
   return $response;
}

function creditSaleToken( $hcws, $params ) {
   $response = $hcws->sendCreditSaleToken( $params );
   return $response;
}

function creditAdjustToken( $hcws, $params ) {
   $response = $hcws->sendCreditAdjustToken( $params );
   return $response;
}

function creditVoidSaleToken( $hcws, $params ) {
   $response = $hcws->sendCreditVoidSaleToken( $params );
   return $response;
}

function creditReversalToken( $hcws, $params ) {
   $response = $hcws->sendCreditReversalToken( $params );
   return $response;
}

function creditReturnToken( $hcws, $params ) {
   $response = $hcws->sendCreditReturnToken( $params );
   return $response;
}

function creditVoidReturnToken( $hcws, $params ) {
   $response = $hcws->sendCreditVoidReturnToken( $params );
   return $response;
}

?>