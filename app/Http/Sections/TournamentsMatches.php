<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\TourneyList;
use checkFile;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Section;

/**
 * Class TournamentsMatches
 *
 * @property \App\Models\TourneyMatch $model
 */
class TournamentsMatches extends Section
{


    /**
     * @var bool
     */
    protected $checkAccess = true;

    /**
     * @var string
     */
    protected $title = 'Список матчей';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return mixed
     */
    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('tourney.name', '<small>Турнир</small>')
                ->setWidth('300px'),
            AdminColumn::text('player1.description', '<small>Игрок 1<br>GameNick/Name</small>', 'player1.user.name')
                ->setWidth('125px'),
            AdminColumn::text('player2.description', '<small>Игрок 2<br>GameNick/Name</small>', 'player2.user.name')
                ->setWidth('125px'),
            AdminColumn::text('player1_score', '<small>Игрок 1<br>очки</small>')->setWidth('67px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('player2_score', '<small>Игрок 2<br>очки</small>')->setWidth('67px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('winner_score', '<small>Чемпион<br>очки</small>')->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('match_number', '<small>№<br>матча</small>')->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('round_number', '<small>№<br>раунда</small>')->setWidth('60px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('<small>Тип<br>матча</small>', function ($model) {
                return TourneyList::$matchType[$model->match_type];
            })->setWidth('60px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('played')->setLabel('<small>Сыграно</small>'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('TournamentsMatchesDataTables')
            ->setOrder([[0, 'desc']])
            ->with('tourney', 'player1:id,user_id,description', 'player2:id,user_id,description', 'player1.user:id,name', 'player2.user:id,name')
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');
        $display->setFilters(
            AdminDisplayFilter::field('tourney_id')->setTitle('Tourney ID [:value]'),
            AdminDisplayFilter::field('round_number')->setTitle('Round NUMBER [:value]')
        );

        return $display;
    }

    protected $getModel, $winner, $matchType = null;

    public function onEdit($id)
    {
        $this->getModel = $this->getModel()->with('player1', 'player2')->select(['match_type', 'player1_id', 'player2_id'])->find($id);

        if ($this->getModel) {
            if ( ! empty($this->getModel->match_type)) {
                $this->matchType = $this->getModel::$matchType[$this->getModel->match_type];
            }

            if ($this->getModel->player1) {
                $this->winner['player1'] = $this->getModel->player1->description;
            }
            if ($this->getModel->player2) {
                $this->winner['player2'] = $this->getModel->player2->description;
            }
        }


        $form = AdminForm::panel();
        $form->addHeader([
            AdminFormElement::text('tourney.name', 'Турнир')->setReadonly(true),
            AdminFormElement::text('match_number', 'Номер матча')->setReadonly(true),
            AdminFormElement::text('round_number', 'Номер раунда')->setReadonly(true),
            AdminFormElement::text('round', 'Раунд')->setReadonly(true),
            AdminFormElement::text('setMatchType', 'Тип матча')->setReadonly(true)
                ->setDefaultValue($this->matchType),
        ]);

        $form->addBody([
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('player1.description', 'Игрок 1(игровой ник)')->setReadonly(true),
                        AdminFormElement::text('player1_score', 'Игрок 1 очки')->setReadonly(true),
                    ];
                }, 6)
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('player2.description', 'Игрок 2(игровой ник)')->setReadonly(true),
                        AdminFormElement::text('player2_score', 'Игрок 2 очки')->setReadonly(true),

                    ];
                }, 6),
            AdminFormElement::columns()->addColumn(function () {
                return [
                    AdminFormElement::select('winner')
                        ->setValidationRules([
                            'nullable',
                            'in:player1,player2',
                        ])
                        ->setOptions($this->winner)
                        ->setLabel('Установить победителя'),
                    AdminFormElement::columns()->addColumn(function () {
                        return [
                            AdminFormElement::text('winner_value', 'Победитель значение')->setReadonly(true),
                            AdminFormElement::text('winner_action', 'Победитель действие')->setReadonly(true),

                        ];
                    }, 6)
                        ->addColumn(function () {
                            return [
                                AdminFormElement::text('looser_value', 'Проигравший значение')->setReadonly(true),
                                AdminFormElement::text('looser_action', 'Проигравший действие')->setReadonly(true),
                            ];
                        }, 6),
                    AdminFormElement::text('winner_score', 'Победитель очки')->setReadonly(true),
                    AdminFormElement::checkbox('played', 'Сыграно')->setValidationRules([
                        'boolean',
                    ]),
                ];
            }, 6)->addColumn(function () {
                return [
                    AdminFormElement::files('reps', 'Файлы')->setValidationRules([
                        'file',
                        'nullable',
                        'max:5120',
                    ])->setUploadPath(function (UploadedFile $file) {
                        return 'storage'.checkFile::checkUploadsFileAndPath('/files/tourney');
                    }),
                ];
            }, 6),


        ]);


        return $form;
    }

    //    /**
    //     * @return FormInterface
    //     */
    //    public function onCreate()
    //    {
    //        return AdminForm::panel()->addBody([
    //            AdminFormElement::text('tourney_id')->setReadonly(true),
    //        ]);
    //    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

}
