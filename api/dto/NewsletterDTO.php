<?php
class NewsletterDTO{
    private $newsletterId = "";
    private $email = "";
    private $status = "";
    private $newsletterToken = "";

    public function getnewsletterId(){
        return $this->newsletterId;
    }
    public function setNewsletterId($newsletterId){
        $this->newsletterId = $newsletterId;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getStatus(){
        return $this->status;
    }
    public function setStatus($status){
        $this->status = $status;
    }

    public function getNewsletterToken(){
        return $this->newsletterToken;
    }
    public function setNewsletterToken($newsletterToken){
        $this->newsletterToken = $newsletterToken;
    }
}
?>