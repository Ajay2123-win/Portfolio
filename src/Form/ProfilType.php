<?php

namespace App\Form;

use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('titre')
            ->add('photoFile', VichImageType::class, [
                  'required' => false,
                  'allow_delete' => true,
                  'download_uri' => false,
                  'imagine_pattern' => false,
                  'label' => 'Photo de profil',
                  ])
            ->add('email')
            ->add('telephone')
            ->add('localisation')
            ->add('bio')
            ->add('lienProjetDeploye')
            ->add('lienGithub')
            ->add('lienLinkedin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
