<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\TourneyMatch;
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
            AdminColumn::text('tourney.name', 'Турнир'),
            AdminColumn::text('player1.description', 'Игрок 1<br><br>GameNick/Name', 'player1.user.name')
                ->setWidth('150px'),
            AdminColumn::text('player2.description', 'Игрок 2<br><br>GameNick/Name', 'player2.user.name')
                ->setWidth('150px'),
            AdminColumn::custom('Игрок 1<br>победитель', function ($model) {
                return $model->player1_score == 2 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('10px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Игрок 2<br>победитель', function ($model) {
                return $model->player2_score == 2 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('10px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Ветка', function ($model) {
                if ( ! empty($model->branch)) {
                    return TourneyMatch::$branches[$model->branch];
                }
                return null;
            })->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('match_number', '№ матча')->setWidth('65px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('round_number', '№ раунда')->setWidth('70px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('played')->setLabel('Сыграно'),

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

    protected $getModel, $winner;

    public function onEdit($id)
    {
        $this->getModel = $this->getModel()->with('player1', 'player2')->select(['player1_id', 'player2_id'])->find($id);

        if ($this->getModel) {
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
