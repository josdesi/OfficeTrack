<?php
class NewsletterDTO{
    private $newsletterId = "";
    private $email = "";

    public function getnewsletterId(){
        return $this->userId;
    }
    public function setNewsletterId($userId){
        $this->userId = $userId;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
}
?>