<?php
class ResponseDTO implements JsonSerializable {
 
    private $code;
    private $message;
    private $response;

    public function getCode(){
        return $this->code;
    }

    public function setCode($code){
        $this->code = $code;
    }

    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getResponse(){
        return $this->response;
    }

    public function setResponse($response){
        $this->response = $response;
    }
    
    public function jsonSerialize() {
        return [            
            'code' => $this->code,
            'message' => $this->message,
            'response' => $this->response
        ];
    }
}
?>