<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\SalesReturnPage\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerShop\Yves\SalesReturnPage\SalesReturnPageFactory getFactory()
 * @method \SprykerShop\Yves\SalesReturnPage\SalesReturnPageConfig getConfig()
 */
class ReturnCreateForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_RETURN_ITEMS = 'returnItems';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addReturnItemsCollection($builder, $options);
        $this->executeReturnCreateFormHandlerPlugins($builder, $options);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            ReturnItemsForm::OPTION_RETURN_REASONS,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return $this
     */
    protected function addReturnItemsCollection(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            static::FIELD_RETURN_ITEMS,
            CollectionType::class,
            [
                'entry_type' => ReturnItemsForm::class,
                'entry_options' => [
                    ReturnItemsForm::OPTION_RETURN_REASONS => $options[ReturnItemsForm::OPTION_RETURN_REASONS],
                ],
                'label' => false,
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
    protected function executeReturnCreateFormHandlerPlugins(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->getFactory()->getReturnCreateFormHandlerPlugins() as $returnCreateFormHandlerPlugin) {
            $builder = $returnCreateFormHandlerPlugin->buildForm($builder, $options);
        }

        return $this;
    }
}
