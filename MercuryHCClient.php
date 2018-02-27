<?php

/**
 * Mercury Payment Systems HostedCheckout PHP Client
 *
 * ©2013 Mercury Payment Systems, LLC - all rights reserved.
 *
 * Disclaimer:
 * This software and all specifications and documentation contained
 * herein or provided to you hereunder (the "Software") are provided
 * free of charge strictly on an "AS IS" basis. No representations or
 * warranties are expressed or implied, including, but not limited to,
 * warranties of suitability, quality, merchantability, or fitness for a
 * particular purpose (irrespective of any course of dealing, custom or
 * usage of trade), and all such warranties are expressly and
 * specifically disclaimed. Mercury Payment Systems shall have no
 * liability or responsibility to you nor any other person or entity
 * with respect to any liability, loss, or damage, including lost
 * profits whether foreseeable or not, or other obligation for any cause
 * whatsoever, caused or alleged to be caused directly or indirectly by
 * the Software. Use of the Software signifies agreement with this
 * disclaimer notice.
 */

class MercuryHCClient
{
   private $merchantId;
   private $password;
   private $wsClientHostedCheckout;
   private $wsClientTransactionService;
   private $cardInfoIFrameBaseURL;
   private $paymentIFrameBaseURL;

   public function __construct($merchantId, $password)
   {
      $this->merchantId = $merchantId;
      $this->password = $password;

      // Development URLs
      $wsdlHostedCheckoutURL = 'https://hc.mercurycert.net/hcws/HCService.asmx?WSDL';
      $wsdlTransactionServiceURL = 'https://hc.mercurycert.net/tws/TransactionService.asmx?WSDL';
      $this->cardInfoIFrameBaseURL = 'https://hc.mercurycert.net/CardInfoiFrame.aspx?cardID=';
      $this->paymentIFrameBaseURL = 'https://hc.mercurycert.net/CheckoutiFrame.aspx?pid=';

      /*
      // Production URLs
      $wsdlHostedCheckoutURL = 'https://hc.mercurypay.com/hcws/HCservice.asmx?WSDL';
      $wsdlTransactionServiceURL = 'https://hc.mercurypay.com/tws/TransactionService.asmx?WSDL';
      $this->cardInfoIFrameBaseURL = 'https://hc.mercurypay.com/CheckoutiFrame.aspx?cardID=';
      $this->paymentIFrameBaseURL = 'https://hc.mercurypay.com/CheckoutiFrame.aspx?pid=';
      */

      $this->wsClientHostedCheckout = new SoapClient($wsdlHostedCheckoutURL);
      $this->wsClientTransactionService = new SoapClient($wsdlTransactionServiceURL, array("trace"=>1));
   }

   public function buildCardInfoIFrameURL( $cardID )
   {
      return $this->cardInfoIFrameBaseURL.$cardID;
   }

   public function buildPaymentIFrameURL( $pid )
   {
      return $this->paymentIFrameBaseURL.$pid;
   }

   public function __call( $name, $args )
   {
      $methodsAvailableHostedCheckout = array(
         'InitializeCardInfo',
         'InitializePayment',
         'VerifyCardInfo',
         'VerifyPayment',
         'DownloadCSS',
         'UploadCSS',
         'RemoveCSS'
      );

      $methodsAvailableTransactionService = array(
         'CreditPreAuthToken',
         'CreditPreAuthCaptureToken',
         'CreditSaleToken',
         'CreditAdjustToken',
         'CreditVoidSaleToken',
         'CreditReversalToken',
         'CreditReturnToken',
         'CreditVoidReturnToken'
      );

      $pre = substr($name, 0, 4);
      $rest = substr($name, 4);

      if ( $pre == 'send' && in_array($rest, $methodsAvailableHostedCheckout) ) {
         $requestData = array_merge(
            array(
               'MerchantID' => $this->merchantId,
               'Password' => $this->password,
            ),
            $args[0]
         );

         $resp = $this->wsClientHostedCheckout->$rest(array('request' => $requestData ));

         return $resp->{$rest.'Result'};
      } elseif ( $pre == 'send' && in_array($rest, $methodsAvailableTransactionService) ) {

         $requestData = array_merge(
            array(
               'MerchantID' => $this->merchantId,
            ),
            $args[0]
         );

         $resp = $this->wsClientTransactionService->$rest(array('request' => $requestData, 'password' => $this->password ));

         return $resp->{$rest.'Result'};
      }

      throw new Exception('Error, the method ' . $rest . ' does not exist');
   }

   public function getTypesHostedCheckout()
   {
      return $this->wsClientHostedCheckout->__getTypes();
   }

   public function getTypesTransactionService()
   {
      return $this->wsClientTransactionService->__getTypes();
   }
}

?>