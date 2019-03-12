<?php
class NewsletterBusinessImpl implements NewsletterBusiness
{
    public function create($newsletterDTO)
    {
        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Newsletter y pasa la conexión a la base de dastos
            $newsletter = new Newsletter($db);

            //Obtener los valores desde el NewsletterDTO que se pasa como parametro
            $newsletterId = $newsletterDTO->getNewsletterId();
            $email = $newsletterDTO->getEmail();
            $status = $newsletterDTO->getStatus();
            $newsletterToken = $newsletterDTO->getNewsletterToken();
            
            //Establece valores de la entidad Newsletter
            $newsletter->newsletterId = $newsletterId;
            $newsletter->email = $email;
            $newsletter->status = $status;
            $newsletter->newsletterToken = $newsletterToken;

            //Crea una fila en la tabla newsletter basado en los valores de la entidad
            $newsletter->create();
        } catch (Exception $e) {
            throw $e;
        }

    }    

    public function update($newsletterDTO)
    {
        try {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Newsletter y se le pasa la conexión a la base de dastos
            $newsletter = new Newsletter($db);

            //Obtener los valores del NewsletterDTO
            $newsletterId = $newsletterDTO->getNewsletterId();
            $email = $newsletterDTO->getEmail();
            $status = $newsletterDTO->getStatus();
            $newsletterToken = $newsletterDTO->getNewsletterToken();

            if (
                empty($newsletterId)
            ) {
                throw new Exception("Es necesario el id para poder actualizar el registro", 1);
            } else {
                //Establece valores de la entidad Newsletter
                $newsletter->newsletterId = $newsletterId;
                $newsletter->email = $email;
                $newsletter->status = $status;
                $newsletter->newsletterToken = $newsletterToken;

                //Actualiza la fila con el mismo id en la tabla newsletter
                $newsletter->update();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($newsletterDTO)
    {
        try {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Newsletter y se le pasa la conexión a la base de dastos
            $newsletter = new Newsletter($db);

            //Obtener los valores del NewsletterDTO
            $newsletterId = $newsletterDTO->getNewsletterId();

            if (
                empty($newsletterId)
            ) {
                throw new Exception("Es necesario el id para poder eleminar el registro", 1);
            } else {
                //Establece valores de la entidad Newsletter
                $newsletter->newsletterId = $newsletterId;

                //Elimina la fila con el mismo id en la tabla newsletter
                $newsletter->delete();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByEmail($email)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Newsletter y se le pasa la conexión a la base de dastos
            $newsletter = new Newsletter($db);

            return $newsletter->findByEmail($email);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByNewsletterToken($newsletterToken)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Newsletter y se le pasa la conexión a la base de dastos
            $newsletter = new Newsletter($db);

            return $newsletter->findByNewsletterToken($newsletterToken);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
