<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\SalesReturnPage\Form;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ReturnItemTransfer;
use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerShop\Yves\SalesReturnPage\SalesReturnPageFactory getFactory()
 * @method \SprykerShop\Yves\SalesReturnPage\SalesReturnPageConfig getConfig()
 */
class ReturnItemsForm extends AbstractType
{
    /**
     * @var string
     */
    public const OPTION_RETURN_REASONS = 'returnReasons';

    /**
     * @var string
     */
    protected const FIELD_CUSTOM_REASON = 'customReason';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addIsReturnable($builder)
            ->addReason($builder, $options)
            ->addCustomReason($builder);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            static::OPTION_RETURN_REASONS,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsReturnable(FormBuilderInterface $builder)
    {
        $builder->add(
            ItemTransfer::IS_RETURNABLE,
            CheckboxType::class,
            [
                'label' => false,
                'required' => false,
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    protected function addReason(FormBuilderInterface $builder, array $options)
    {
        $builder->add(ReturnItemTransfer::REASON, ChoiceType::class, [
            'label' => false,
            'placeholder' => 'return_page.return_reasons.select_reason.placeholder',
            'choices' => $options[static::OPTION_RETURN_REASONS],
            'required' => false,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomReason(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CUSTOM_REASON, TextareaType::class, [
            'label' => false,
            'required' => false,
        ]);

        return $this;
    }
}
