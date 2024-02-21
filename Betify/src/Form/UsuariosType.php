<?php
// src/Form/UsuariosType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormTypeInterface;

class UsuariosType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreUsuario', TextType::class, [
                'label' => 'Nombre de Usuario',
            ])
            ->add('email', TextType::class, [
                'label' => 'Correo Electrónico',
            ])
            ->add('password', TextType::class, [
                'label' => 'Contraseña',
            ]);
        // Puedes agregar más campos según sea necesario
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Entity\Usuarios',
        ]);
    }
}