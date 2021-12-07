<?php 
require_once('IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Sample
{
    public static function options()
    {
        # create client configuration
        $options = new \Iyzipay\Options();
         $options->setApiKey("fAbfdUlUHJD6a5nrG93TyCcM6EP8SWT9");
        $options->setSecretKey("doBiVFabBVmfZefpZk0sSKqCd6tzVM0H");
		$options->setBaseUrl("https://api.iyzipay.com");
        return $options;
    }
}
?>