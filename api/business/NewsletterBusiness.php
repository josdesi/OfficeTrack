<?php

interface NewsletterBusiness {

   public function create( $newsletterDTO );
   public function update( $newsletterDTO );
   public function findByNewsletterToken( $newsletterToken );
   
}
?>