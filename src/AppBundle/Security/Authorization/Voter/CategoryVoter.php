<?php

namespace AppBundle\Security\Authorization\Voter;

use AppBundle\Entity\Product\Category;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Description of Category
 *
 * @author Diba
 */
class CategoryVoter extends Voter {

    const EDIT = 'edit';
    const DELETE = 'delete';
    const SHOW = 'show';

    protected function supports($attribute, $subject) {
        if (!in_array($attribute, [self::EDIT, self::DELETE, self::SHOW])) {
            return false;
        }

        if (!$subject instanceof Category) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $category = $subject;

        switch ($attribute) {
            case self::EDIT:
            case self::DELETE:
            case self::SHOW:
                if ($this->isOwner($category, $user)) {
                    return true;
                }
        }
        return false;
    }

    private function isOwner(Category $category, User $user) {
        if ($user->getId() == $category->getUser()->getId()) {
            return true;
        }
        return false;
    }

}
