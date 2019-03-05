<?php
class NewsletterBusinessImpl implements NewsletterBusiness
{
    public function createNewsletter($newsletterDTO)
    {
        try
        {
            $database = new Database();
            $db = $database->getConnection();
            $newsletter = new Newsletter($db);

            $newsletter->email = $newsletterDTO->getEmail();
            $newsletter->createNewsletter();

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function findByEmail($email)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $newsletter = new Newsletter($db);

            return $newsletter->findByEmail($email);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
