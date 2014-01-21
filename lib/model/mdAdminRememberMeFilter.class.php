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
class mdAdminRememberMeFilter extends sfFilter {

    /**
     * Executes the filter chain.
     *
     * @param sfFilterChain $filterChain
     */
    public function execute($filterChain) {
        if (
          $this->isFirstCall()
          &&
          $cookie = $this->context->getRequest()->getCookie('__MD_RMU')
        ) {
            $data = unserialize(base64_decode($cookie));
            try {
                $user = $this->getUser()->validateLogin($data[0], $data[1]);

                $this->getUser()->signin($user);
            } catch (Exception $e) {
                
            }
        }

        $filterChain->execute();
    }

}
