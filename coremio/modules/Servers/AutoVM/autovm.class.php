<?php

class Autovm
{
	public $error,$url;
    public $key,
           $userId,
           $vpsId,
           $serverId,
           $ipId,
           $datastoreId,
           $osId,
           $planId,
           $ram,
           $cpuMhz,
           $cpuCore,
           $hard,
           $bandwidth,
           $email,
           $hostname,
           $password,
	   $firstName,
           $lastName;

	public function __construct($ip='',$username='',$password=''){
	    $this->url = $username;
	    $this->key = $password;
    }

	public function generatePassword()
	{
		$a = 'abcdefghijklmnopqrstuvwxyz';
		$b = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$c = '0123456789';

		$result = '';

		for ($i=0; $i<3; $i++) {
			$result .= $a[mt_rand(0, strlen($a)-1)];
		}

		for ($i=0; $i<3; $i++) {
			$result .= $b[mt_rand(0, strlen($b)-1)];
		}

		for ($i=0; $i<3; $i++) {
			$result .= $c[mt_rand(0, strlen($c)-1)];
		}

		return $result;
	}

    public function create()
    {
        if (!$this->userId) {
            $this->userId = $this->getUserId();
        }

        if (!$this->userId) {
            $this->userId = $this->createUser();
        }

        if (!$this->userId) {
            return false;
        }

        return ($this->vpsId = $this->createVps());
    }

    public function info()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/info', $options);

        if ($result) {
            return $result;
        }

        return false;
    }

	public function login()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/access', $options);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function adminLogin()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
            'email' => $this->email,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/admin-access', $options);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function osList()
    {
        $data = [
            'key' => $this->key,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/os', $options);

        if ($result) {
            return $result;
        }

        return false;
    }

    public function active()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/active', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function inactive()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/inactive', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/delete', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function install()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
            'os' => $this->osId,
            'password' => $this->password,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/install', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function start()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/start', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function stop()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/stop', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function restart()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/restart', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function resetBandwidth()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/reset-bandwidth', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function ips()
    {
        $data = [
            'key' => $this->key,
            'serverId' => $this->serverId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/server/ip', $options);

        if ($result) {
            return $result->ips;
        }

        return false;
    }

    protected function getUserId()
    {
        $data = [
            'key' => $this->key,
            'email' => $this->email,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/user/info', $options);

        if ($result) {
            return $result->id;
        }

        return false;
    }

    public function upgrade()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
            'planId' => $this->planId,
            'ram' => $this->ram,
            'cpuMhz' => $this->cpuMhz,
            'cpuCore' => $this->cpuCore,
            'hard' => $this->hard,
            'bandwidth' => $this->bandwidth,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/update', $options);

        if ($result) {
            return true;
        }

        return false;
    }

    public function downgrade_table()
    {
        $data = [
            'key' => $this->key,
            'id' => $this->vpsId,
            'plan' => $this->planId
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/downgrade-table', $options);

        if ($result) {
            return true;
        }

        return false;
    }

	public function check()
    {
        $data = [
            'key' => $this->key,
            'serverId' => $this->serverId,
			'datastoreId' => $this->datastoreId,
			'planId' => $this->planId,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/check', $options);

        if (!$result) {
            return false;
        }

		if (!$result->server) {
			$this->log('The server was not found');
			return false;
		}

		if (!$result->datastore) {
			$this->log('The datastore was not found');
			return false;
		}

		if (!$result->plan) {
			$this->log('The plan was not found');
			return false;
		}

        return true;
    }

    protected function createVps()
    {
		$result = $this->check();

		if (!$result) {
			return false;
		}

		$result = $this->ips();

		if (empty($result) && $result !== false) {
			$this->log('There is no free ip');
			return false;
		}

        $data = [
            'key' => $this->key,
            'userId' => $this->userId,
            'serverId' => $this->serverId,
            'ipId' => $this->ipId,
            'datastoreId' => $this->datastoreId,
            'osId' => $this->osId,
            'planId' => $this->planId,
            'vpsRam' => $this->ram,
            'vpsCpuMhz' => $this->cpuMhz,
            'vpsCpuCore' => $this->cpuCore,
            'vpsHard' => $this->hard,
            'vpsBandwidth' => $this->bandwidth,
            'hostname' => $this->hostname,
            'password' => $this->password,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/vps/create', $options);

        if ($result) {
            return $result->id;
        }

        return false;
    }

    protected function createUser()
    {
        $data = [
            'firstName' => $this->firstName,
	    'lastName' => $this->lastName,
            'key' => $this->key,
            'email' => $this->email,
            'password' => $this->password,
        ];

        $options = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ];

        $result = $this->curlRequest($this->url . '/user/create', $options);

        if ($result) {
            return $result->id;
        }

        return false;
    }

	public function log($data)
	{
        $this->error = $data;
		return true;
	}

    protected function curlRequest($url, $options = [])
    {
        $c = curl_init();

        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);

        foreach ($options as $key => $value) {
            curl_setopt($c, $key, $value);
        }

        $result_x   = curl_exec($c);
        $result     = $result_x;

        if(!$result || curl_errno($c)){
            $curl_error = curl_error($c);
            $this->log("cURL Error: ".$curl_error);
            $result = false;
        }

        curl_close($c);

        if(stristr($result,"}{")){
            $split      = explode("}{",$result);
            $result     = $split[0]."}";
        }

        $result = $result ? json_decode($result) : false;

        Modules::save_log("Servers","AutoVM",$url,$options[CURLOPT_POSTFIELDS],$result_x,$this->error ?? $result);

        if(is_object($result) && $result->ok == true) return $result;

        return false;
    }
}
