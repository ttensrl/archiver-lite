<?php

namespace LaravelBricks\ArchiverLite\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\MediaRepository;

class Archiver extends Component
{
    use WithFileUploads;

    /**
     * @var array File Input
     */
    public $files = [];

    /**
     * @var null
     */
    public $validationRules = null;

    /**
     * @var null
     */
    public $validationMessage = null;

    /**
     * @var
     */
    public $customProperty;

    /**
     * @var array
     */
    public $propertyFields = [];

    /**
     * @var array
     */
    public $propertyRules = [];

    /**
     * @var
     */
    public $propertyView = null;

    /**
     * @var array
     */
    public $collections = [];

    /**
     * @var string
     */
    public $selectedCollection = '';

    /**
     * @var Il nome della Classe che implementa Has Media
     */
    public $mediaClass;

    /**
     * @var L'id dell'oggetto da lavorare
     */
    public $mediaObjectId;

    /**
     * @var int Iterazione Necessaria per resettare l'ID del campo file
     */
    public $iteration = 0;

    /**
     * @param  HasMedia  $objHasMedia
     */
    public function mount(HasMedia $objHasMedia)
    {

        $this->mediaClass    = get_class($objHasMedia);
        $this->mediaObjectId = $objHasMedia->id;
        $objExtraField       = $objHasMedia->getMediaCustomFields();
        $this->collections   = $objHasMedia->getMediaCollections();

        $this->validationRules = $this->validationRules ?? config('bricks-archiver-lite.validation');
        $this->validationMessage = $this->validationMessage ?? ['files.*.*' => 'Non è stato possibile aggiungere questi file'];

        if (count($this->collections) > 0) {
            $this->selectedCollection = key($this->collections);
        }
        if (count($objExtraField) > 0) {
            $this->propertyFields = $objExtraField['fields'];
            $this->propertyRules  = $objExtraField['rules'];
            $this->propertyView   = $objExtraField['view'];
            $this->loadCustomProperty();
        }

    }

    /**
     * ricarica il valore dei campi opzionali delle immagini, quando si passa ad un'altra collezione
     *
     * @return void
     */
    public function updatedSelectedCollection()
    {
        if (count($this->propertyFields) > 0) {
            $this->loadCustomProperty();
        }
    }

    /**
     * Aggiunge i fiel all'oggetto che ha il tratto HasMedia
     */
    public function addMedia()
    {
        $this->validate($this->validationRules, $this->validationMessage);

        foreach ($this->files as $photo) {
            $photo->store('files', 'public');
            if (count($this->getObjectMedia()->getMedia($this->selectedCollection)) > 0) {
                $this->getObjectMedia()->addMedia($photo)->preservingOriginal()->toMediaCollection($this->selectedCollection);
            } else {
                //First Media
                $media          = $this->getObjectMedia()->addMedia($photo)->preservingOriginal()->toMediaCollection($this->selectedCollection);
                $media->default = true;
                $media->save();
            }
        }

        $this->files = null;
        $this->iteration++;
    }

    /**
     * Cancella il media legato all'oggetto
     *
     * @param $index
     *
     */
    public function removeMedia($index)
    {
        $media_delete = $this->getObjectMedia()->getMedia($this->selectedCollection);
        $media_delete[$index]->delete();
        if ($media_delete[$index]->default && count($media_delete) > 1) {
            $media_new_default          = $this->getObjectMedia()->getMedia($this->selectedCollection)->first();
            $media_new_default->default = true;
            $media_new_default->save();
        }
    }

    /**
     * Salva i campi opzionali
     *
     * @param $index
     *
     * @return void
     */
    public function saveCustomProperty($index)
    {
        $this->validate($this->propertyRules);
        $mediaObj = $this->getObjectMedia()->getMedia($this->selectedCollection);
        foreach ($this->propertyFields as $field) {
            $mediaObj[$index]->setCustomProperty($field, $this->customProperty[$index][$field]);
        }
        $mediaObj[$index]->save();
    }

    /**
     * Crica i campi opzionali
     *
     * @return void
     */
    public function loadCustomProperty()
    {
        $mediaObj = $this->getObjectMedia()->getMedia($this->selectedCollection);
        foreach ($mediaObj as $index => $photo) {
            foreach ($this->propertyFields as $field) {
                $this->customProperty[$index][$field] = $photo->getCustomProperty($field) ?? null;
            }
        }
    }

    /**
     * @param $idToDefault
     *
     * @return void
     */
    public function toggle_default($index)
    {
        $exDefaultMedia          = $this->getObjectMedia()->getDefaultMedia($this->selectedCollection);
        $exDefaultMedia->default = false;
        $exDefaultMedia->save();
        $mediaObj                  = $this->getObjectMedia()->getMedia($this->selectedCollection);
        $mediaObj[$index]->default = true;
        $mediaObj[$index]->save();
    }

    /**
     * Ottiene l'oggetto per ogni iterazione
     *
     * @return mixed
     *
     */
    public function getObjectMedia()
    {
        return $this->mediaClass::find($this->mediaObjectId);
    }

    /**
     * Renderizza il componente
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function render()
    {
        $medias = $this->getObjectMedia()->getMedia($this->selectedCollection);

        return view('bricks-archiver-lite::livewire.media-upload', compact('medias'));
    }
}
