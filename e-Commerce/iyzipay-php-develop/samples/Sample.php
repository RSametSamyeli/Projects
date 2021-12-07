<?php

require_once('../IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Sample
{
    public static function options()
    {
        # create client configuration
        $options = new \Iyzipay\Options();
        $options->setApiKey("FA4PB5KPSPvzlX3a21sZsR8Ka6RVM5Wk");
        $options->setSecretKey("Bd1B6IrFgBnMXxbsUDkum3H3KzpzztFb");
        $options->setBaseUrl("https://api.iyzipay.com");
        return $options;
    }
}