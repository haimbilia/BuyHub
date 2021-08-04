<?php 

trait ReturnOrders
{
    /**
     * Create a return order
     *
     * @param array $attributes Order data
     * @return void
     */
    public function createReturnOrder($attributes = [])
    {
        return $this->request('post', 'orders/create/return', $attributes);
    }

    /**
     * Cancel order
     *
     * @param array $attributes Order data
     * @return void
     */
    public function cancelOrder($attributes = [])
    {
        return $this->request('post', 'orders/cancel', $attributes);
    }

    /**
     * Makes a request to the Shiprocket API and returns the response.
     *
     * @param    string $verb       The Http verb to use
     * @param    string $path       The path of the APi after the domain
     * @param    array  $parameters Parameters
     *
     * @return   stdClass The JSON response from the request
     * @throws   Exception
     */
    abstract protected function request($verb, $path, $parameters = []);
}
