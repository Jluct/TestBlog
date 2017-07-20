<?php
/**
 * Created by PhpStorm.
 * User: Inkognito
 * Date: 20.07.2017
 * Time: 18:21
 */

namespace Jluct\BlogBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jluct\BlogBundle\Entity\Post;

class LoadPostFixture implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return int if success upload in database return 0, esle return 1
     *
     */
    public function load(ObjectManager $manager)
    {
        $count = count($this->getText());

        for ($i = 0; $i < $count; $i++) {
            $post = $this->generate($i);
            $manager->persist($post);
        }

        try {
            $manager->flush();
            return 0;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return 1;
        }
    }

    /**
     * @param $i integer for selection title from $this->getText()
     * @return Post
     */
    private function generate($i)
    {
        $post = new Post();
        $post->setTitle($this->getText()[$i]);
        $post->setImage("http://via.placeholder.com/350x350");
        $post->setContent($this->getContent());
        $post->setPublic(mt_rand(0, 9));

        return $post;

    }

    /**
     * Generate string with max length 500 char.
     *
     * @return string
     */
    private function getContent()
    {
        $data = $this->getText();
        $start_num = mt_rand(0, count($data) - 3);
        $end_num = mt_rand($start_num, count($data) - 1);
        shuffle($data);

        return substr(implode(' ', array_slice($data, $start_num, $end_num)), 0, 500);
    }

    /**
     * Contains array with strings for title and generation post content
     *
     * @return array
     */
    private function getText()
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
            'Pellentesque vitae velit ex.',
            'Mauris dapibus risus quis suscipit vulputate.',
            'Eros diam egestas libero eu vulputate risus.',
            'In hac habitasse platea dictumst.',
            'Morbi tempus commodo mattis.',
            'Ut suscipit posuere justo at vulputate.',
            'Ut eleifend mauris et risus ultrices egestas.',
            'Aliquam sodales odio id eleifend tristique.',
            'Urna nisl sollicitudin id varius orci quam id turpis.',
            'Nulla porta lobortis ligula vel egestas.',
            'Curabitur aliquam euismod dolor non ornare.',
            'Sed varius a risus eget aliquam.',
            'Nunc viverra elit ac laoreet suscipit.',
            'Pellentesque et sapien pulvinar consectetur.',
            'Ubi est barbatus nix.',
            'Abnobas sunt hilotaes de placidus vita.',
            'Ubi est audax amicitia.',
            'Eposs sunt solems de superbus fortis.',
            'Vae humani generis.',
            'Diatrias tolerare tanquam noster caesium.',
            'Teres talis saepe tractare de camerarius flavum sensorem.',
            'Silva de secundus galatae demitto quadra.',
            'Sunt accentores vitare salvus flavum parses.',
            'Potus sensim ad ferox abnoba.',
            'Sunt seculaes transferre talis camerarius fluctuies.',
            'Era brevis ratione est.',
            'Sunt torquises imitari velox mirabilis medicinaes.',
            'Mineralis persuadere omnes finises desiderium.',
            'Bassus fatalis classiss virtualiter transferre de flavum.',
        ];
    }


}