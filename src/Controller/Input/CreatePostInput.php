<?php
declare(strict_types=1);

namespace App\Controller\Input;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreatePostInput extends AbstractType
{
    private string $title;
    private string $subTitle;
    private string $content;
    private string $image;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    public function setSubTitle(string $subTitle): void
    {
        $this->subTitle = $subTitle;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class)
                ->add('sub_title', TextType::class)
                ->add('content', TextType::class)
                ->add('image', FileType::class, [
                    'attr' => [
                        'accept' => 'image/png,image/jpeg,image/gif'
                    ]
                ])
                ->add('create', SubmitType::class);
    }
}
