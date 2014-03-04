<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Processes the "remember me" cookie.
 * 
 * This filter should be added to the application filters.yml file **above**
 * the security filter:
 * 
 *    remember_me:
 *      class: mdUserContentRememberMeFilter
 * 
 *    security: ~
 * 
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardRememberMeFilter.class.php 23170 2009-10-18 17:30:33Z FabianLange $
 */
class mdPassportRememberMeFilter extends sfFilter
{
  /**
   * Executes the filter chain.
   *
   * @param sfFilterChain $filterChain
   */
  public function execute($filterChain)
  {
    $cookieName = sfConfig::get('app_md_passport_remember_cookie_name', 'mdRemember');

    if (
      $this->isFirstCall()
      &&
      $this->context->getUser()->isAnonymous()
      &&
      $cookie = $this->context->getRequest()->getCookie($cookieName)
    )
    {
      $q = Doctrine::getTable('mdPassportRememberKey')->createQuery('r')
            ->innerJoin('r.mdPassport u')
            ->where('r.remember_key = ?', $cookie);

      if ($q->count())
      {
        try{
          $this->context->getUser()->signIn($q->fetchOne()->mdPassport);
        }catch(Exception $e){
          
        }
      }
    }

    $filterChain->execute();
  }
}
