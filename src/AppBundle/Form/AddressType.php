<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use AppBundle\Entity\Address;

class AddressType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class,['label'=>'label.first.name','attr'=>['class'=>'form-control mb-2']])
                ->add('lastname', TextType::class,['label'=>'label.last.name','attr'=>['class'=>'form-control mb-2']])
                ->add('email', EmailType::class,['label'=>'label.email','attr'=>['class'=>'form-control mb-2']])
                ->add('phonenumber', TelType::class,['label'=>'label.phonenumber','attr'=>['class'=>'form-control mb-2']])
                ->add('street_address', TextType::class,['label'=>'label.streetaddress','attr'=>['class'=>'form-control mb-2']])
                ->add('zip', TextType::class,['label'=>'label.zip','attr'=>['class'=>'form-control mb-2']])
                ->add('city', TextType::class,['label'=>'label.city','attr'=>['class'=>'form-control mb-2']])
                ->add('country', CountryType::class,['label'=>'label.country','attr'=>['class'=>'form-control mb-2']])
                ->add('dob', BirthdayType::class,['widget'=>'single_text','label'=>'label.dob','attr'=>['class'=>'mb-3']])
                ->add('picture', FileType::class,['label'=>'label.picture','mapped' => true,'required'=>false,'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (jpg,png,gif).',
                    ])
                ],'attr'=>['class'=>'form-control mb-2']])
                ->add('save', SubmitType::class, ['attr'=>['class'=>'btn btn-success my-3'],'label' => 'label.save'])
                ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}