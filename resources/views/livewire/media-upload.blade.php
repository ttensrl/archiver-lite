<div>
    <div class="card" >
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>{{ __('bricks-archiver-lite::archiver-lite.card.title') }}</h3>
        </div>
        <div class="card-body p-2 bg-light border-bottom border-light-800">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-5">
                        <div class="form-group row">
                            <input type="file" class="form-control form-control-sm" wire:model="files" multiple name="files" id="upload{{ $iteration }}">
                            @error('files.*') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @if(count($collections) > 0)
                    <div class="col">
                        <div class="form-group row justify-content-between">
                            <label for="selectedMedia" class="col-4 col-form-label col-form-label-sm" style="text-align: right;">{{ __('bricks-archiver-lite::archiver-lite.collection.select') }}</label>
                            <div class="col-8">
                            <select class="col-8 form-control form-control-sm" wire:model.lazy="selectedCollection" >
                                @foreach($collections as $key=>$label)
                                    <option value="{{ $key }}" @if($selectedCollection == $key) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                            </div>
                            @error('files.*') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
            @foreach($medias as $index => $media)
                <div class="card col-md-3 border me-1" >
                    @if(config('bricks-archiver-lite.easy_flux_support'))
                        <livewire:flux-status :flowable="$media" :wire:key="'media-flowable-key-'.$media->id" template="{{ config('bricks-archiver-lite.easy_flux_template') }}" />
                    @endif
                    @if($media->default)

                            <a class="btn btn-sm btn-success" wire:click.stop="toggle_default({{ $index }})"><i class="fa fa-check"></i></a>

                    @else

                            <a class="btn btn-sm btn-outline-success" wire:click.stop="toggle_default({{ $index }})"><i class="fa fa-check"></i></a>


                    @endif
                    <img src="{{ $media->getFullUrl() }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        @isset($propertyView)
                        @include($propertyView, ['index' => $index])
                        <a class="btn btn-info" wire:click="saveCustomProperty({{$index}})">{{ __('bricks-archiver-lite::archiver-lite.collection.element.save') }}</a>
                        @endisset
                    </div>
                    <button type="button" wire:click="removeMedia({{$index}})" class="btn-close" aria-label="{{ __('bricks-archiver-lite::archiver-lite.collection.element.remove') }}" style="cursor: pointer; relative: absolute; float: right;"></button>
                </div>
            @endforeach
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-secondary" wire:click="addMedia">{{ __('bricks-archiver-lite::archiver-lite.collection.save') }}</button>
        </div>
    </div>
</div>
