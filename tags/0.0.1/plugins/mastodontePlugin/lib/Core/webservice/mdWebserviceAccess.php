<?php

class mdWebserviceAccess
{
    const WS_DEBUG      = false;

    const ERROR_CONNECTING = 800;

    const ERROR_INVOCATION = 801;

    public function  __construct()
    {
    }

    protected function call($wsdl, $service, $input = array())
    {
        try
        {
            $clientSoap = new nusoap_client($wsdl, true);
            $clientSoap->decodeUTF8(false);
            
            $error = $clientSoap->getError();

            if ($error)
            {

                throw new Exception('mdWebserviceAccess::call - Error connecting: ' . $error, self::ERROR_CONNECTING);

            }
            else
            {

                $result = $clientSoap->call($service, $input);

                if ($clientSoap->fault)
                {

                    throw new Exception('mdWebserviceAccess::call - Error invoking method: ' . $clientSoap->getError(), self::ERROR_INVOCATION);

                }

                $this->debug($clientSoap);

                return $result;

            }

        }
        catch(Exception $e)
        {

            throw $e;

        }
    }

    protected function debug($resource)
    {
        if(self::WS_DEBUG)
        {
            echo "<h2>Request</h2>";
            echo "<pre>" . htmlspecialchars($resource->request, ENT_QUOTES) . "</pre>";
            echo "<h2>Response</h2>";
            echo "<pre>" . htmlspecialchars($resource->response, ENT_QUOTES) . "</pre>";
            echo "<h2>Debug</h2>";
            echo "<pre>" . htmlspecialchars($resource->debug_str, ENT_QUOTES) . "</pre>";
        }
    }
}
