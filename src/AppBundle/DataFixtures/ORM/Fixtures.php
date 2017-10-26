<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Review;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{

    private $dummy_text = "Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Ut enim ad minim veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum";

    public function __construct()
    {

    }

    private function randomString($words_count = 1)
    {
        $words = explode(' ', ucwords($this->dummy_text));
        shuffle($words);

        $str = '';
        for ($i = 0; $i < $words_count; $i++)
        {
            $str .= array_pop($words) . ' ';
        }

        $str = trim($str);

        return $str;
    }

    public function load(ObjectManager $manager)
    {
        // create users
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setName($this->randomString());
            $user->setFacebookId($this->randomString(1));
            $user->setEmail($this->randomString(1) . '@' . $this->randomString(1) . '.com' );
            //$user->setLastLoginTime(new \DateTime("now"));
            $manager->persist($user);

            $users[] = $user;
        }

        // create sites
        for ($i = 0; $i < 5; $i++) {
            $site = new Site();
            $site->setUrl(strtolower($this->randomString() . '.' . $this->randomString() . '.com'));
            $site->setTitle($this->randomString(4));
            $site->setDescription($this->randomString(20));
            $site->setFlag(1);
            $manager->persist($site);

            // fill in reviews
            for ($n = 0; $n < 4; $n++) {
                $review = new Review();
                $review->setTitle($this->randomString(4));
                $review->setReview($this->randomString(20));
                $review->setDateCreated(new \DateTime("now"));
                $review->setUser($users[rand(0, 4)]);
                $review->setRating(rand(-5, 20));
                $review->setSite($site);
                $review->setFlag(1);

                $manager->persist($review);
            }

            // add comments to site
            for ($m = 0; $m < 7; $m++) {
                $comment = new Comment();
                $comment->setText($this->randomString(rand(5, 15)));
                $comment->setDateCreated(new \DateTime("now"));
                $comment->setUser($users[rand(0, 4)]);
                $comment->setSite($site);
                $comment->setRating(rand(-5, 20));
                $comment->setFlag(1);
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
