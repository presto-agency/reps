<?php

namespace App\Http\Sections;

use AdminForm;
use AdminFormElement;
use App\Models\MetaTag;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;

/**
 * Class MetaTags
 *
 * @property \App\Models\MetaTag $model
 */
class MetaTags extends Section
{

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'MetaTag для главной';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return \SleepingOwl\Admin\Form\FormElements
     */
    public function onDisplay()
    {
        $id = MetaTag::query()->value('id');
        if ( ! is_null($id)) {
            $oneForm[] = $this->fireEdit($id);
        } else {
            $oneForm[] = $this->fireCreate();
        }

        return new FormElements($oneForm);
    }

    /**
     * @param $id
     *
     * @return \SleepingOwl\Admin\Form\FormPanel
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('seo_title', 'Seo Title')
                ->setHtmlAttribute('placeholder', 'Seo Title')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('required', 'required')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            AdminFormElement::text('seo_keywords', 'Seo Keywords')
                ->setHtmlAttribute('placeholder', 'Seo Keywords')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('required', 'required')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            AdminFormElement::text('seo_description', 'Seo Description')
                ->setHtmlAttribute('placeholder', 'Seo Description')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('required', 'required')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
        ]);
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

}
