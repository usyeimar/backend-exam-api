<?php

namespace App\Services\Customers;

use Illuminate\Support\Facades\Storage;
use Nyholm\Psr7\UploadedFile;

class UploadDocumentForCustomer
{

    /**
     * @param UploadedFile $document
     * @param string $customerId
     * @return void
     */
    public function __invoke(
        UploadedFile $document,
        string $customerId
    ) {

        $fileName = $customerId.'_'.time().'.'.$document->getClientOriginalExtension();

        $uploadedFile = Storage::disk('public')
            ->put(
                'documents/'.$fileName,
                $document
            );

        dd($uploadedFile);


    }
}
