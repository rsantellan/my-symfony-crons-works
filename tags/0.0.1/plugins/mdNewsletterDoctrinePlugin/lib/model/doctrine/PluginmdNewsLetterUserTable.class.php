<?php
/**
 */
class PluginmdNewsLetterUserTable extends Doctrine_Table
{

    public function retrieveAllUsersOfNewsLetter($page = null, $limit = null)
    {
        $query = Doctrine_Query::create()
                ->select('mdU.*')
                ->from('mdUser mdU, mdNewsLetterUser mdNLU')
                ->where('mdU.id = mdNLU.md_user_id');
        if(!is_null($page) && !is_null($limit))
        {
            $query->limit($limit);
            $query->offset($page * $limit);
        }
        
        return $query->execute();
    }

    public function retrieveNewsletters($page = null, $limit = null)
    {
        $query = Doctrine_Query::create()
                ->select('mdN.*')
                ->from('mdNewsLetterUser mdN');
        if(!is_null($page) && !is_null($limit))
        {
            $query->limit($limit);
            $query->offset($page * $limit);
        }

        return $query->execute();
    }

    public function retrieveNewsLetterUserByEmail($email)
    {
      $query = $this->createQuery("mdNL")
                  ->select("mdNL.*")
                  ->addFrom("mdUser mdU")
                  ->addWhere("mdNL.md_user_id = mdU.id")
                  ->addWhere("mdU.email = ?", $email);
      return $query->fetchOne();
      
    }

    public function retrieveAllNewsLettersIds()
    {
        $query = $this->createQuery("mdNL");
        $query->select("mdNL.id");
        $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);
        return $query->execute();

    }
}
