<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CatProfileSeeder::class,
            CatDeterminantSeeder::class,
            CatTransactionTypeSeeder::class,
            UsersTableSeeder::class,
            CatConsulateSeeder::class,
            CatAdministrativeUnitSeeder::Class,
            CatSectionTypeSeeder::class,
            CatSectionSeeder::class,
            CatPrimaryValuesSeeder::class,
            CatDocumentaryValiditieSeeder::class,
            CatSelectionTechniquesSeeder::class,
            CatSeriesSeeder::class,
            CatSubseriesSeeder::class,
            CatDescriptionSeeder::class,

            AdminUnitSectionSeeder::class,
            SeriesPrimaryValuesSeeder::class,
            DescriptionSubseriesSeeder::class,
            DescriptionUnitsSeeder::class
        ]);
    }
}
