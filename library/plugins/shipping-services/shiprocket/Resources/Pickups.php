<?php 
trait Pickups
{
    /**
     * @return   stdClass               The JSON response from the request
     */
    public function getPickups()
    {
        return $this->request('get', 'settings/company/pickup');
    }
	
	public function createPickup($attributes = [])
    {
        return $this->request('post', 'settings/company/addpickup', $attributes);
    }
	
	abstract protected function request($verb, $path, $parameters = []);
}
