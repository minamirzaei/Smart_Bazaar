<?php

namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\Product\Product;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Description of Product
 *
 * @author Diba
 */
class ProductVoter extends Voter {

    const EDIT = 'edit';
    const DELETE = 'delete';
    const SHOW = 'show';

    protected function supports($attribute, $subject) {
        if (!in_array($attribute, [self::EDIT, self::DELETE, self::SHOW])) {
            return false;
        }

        if (!$subject instanceof Product) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $product = $subject;

        switch ($attribute) {
            case self::EDIT:
            case self::DELETE:
            case self::SHOW:
                if ($this->isOwner($product, $user)) {
                    return true;
                }
        }
        return false;
    }

    private function isOwner(Product $product, User $user) {
        if ($user->getId() == $product->getUser()->getId()) {
            return true;
        }
        return false;
    }
}
