@php
    $gridData = [
    'dataProvider' => $dataProvider,
    'title' => '',
    'useFilters' => true,
    'columnFields' => [
        'station_id',
        'equipment_id',
        'protection_id',
        'start_time',
        'end_time',
        'duration',
        'weather',
        'cause_outage_id',
        'current_voltage',
        'current_amper',
        'cosf',
        'ude',
        [
            'label' => 'Actions', // Optional
            'class' => Itstructure\GridView\Columns\ActionColumn::class, // Required
            'actionTypes' => [ // Required
                'view',
                'edit' => function ($data) {
                    return '/admin/pages/' . $data->id . '/edit';
                },
                [
                    'class' => Itstructure\GridView\Actions\Delete::class, // Required
                    'url' => function ($data) { // Optional
                        return '/admin/pages/' . $data->id . '/delete';
                    },
                    'htmlAttributes' => [ // Optional
                        'target' => '_blank',
                        'style' => 'color: yellow; font-size: 16px;',
                        'onclick' => 'return window.confirm("Are you sure you want to delete?");'
                    ]
                ]
            ]
        ]
    ]
];
@endphp

@gridView($gridData)
