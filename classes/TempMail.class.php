<?php
class TempMail
{
    private $username, $domain, $inbox = [];

    public function __construct($username, $domain)
    {
        $this->username = $username;
        $this->domain = $domain;
    }

    private function callApi($url, $params = [])
    {
        $endUrl = 'https://tempmailgen.com/api/' . $url . '?' . http_build_query($params);

        $response = file_get_contents($endUrl);
        if (!$response = json_decode($response, true)) {
            throw new Exception('Can\'t decode json');
        }
        

        if (!isset($response['success'])) {
            throw new Exception('Problem with connection or email service');
        }
        if (!$response['success']) {
            if (isset($response['message'])) {
                throw new Exception($response['message']);
            } else {
                throw new Exception('Email service returned an error');
            }
        }

        return $response;
    }
    public function inbox()
    {
        $inbox = $this->callApi('getMessages', [
            'username' => $this->username,
            'domain' => $this->domain,
        ]);
        if (isset($inbox['result']['email'])) {
            $this->inbox = $inbox['result']['email'];
        }
        return $this;
    }
    public function getInbox()
    {
        return $this->inbox;
    }
    public function getFullAddress()
    {
        $fullAddress = $this->username . '@' . $this->domain;

        return $fullAddress;
    }
    public function getEmail($id)
    {
        $inbox = $this->callApi('fetchMessage', [
            'username' => $this->username,
            'domain' => $this->domain,
            'email_id' => $id,
        ]);
        return $inbox;
    }
    public function getLastEmail()
    {
        if (count($this->inbox) <= 0) {
            return [
                'success' => false,
                'message' => 'There are no messages',
            ];
        }
        
        $emails = array_map(function($elem) {
            $elem['unix'] = strtotime($elem['date']);
            return $elem;
        }, $this->inbox);

        usort($emails, function($a, $b) {
            return $b['unix'] <=> $a['unix'];
        });

        $inbox = $this->callApi('fetchMessage', [
            'username' => $this->username,
            'domain' => $this->domain,
            'email_id' => $emails[0]['email_id'],
        ]);
        return $inbox;
    }
}