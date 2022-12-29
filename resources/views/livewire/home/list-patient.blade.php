<div>
    <div class="row">
        @foreach($services as $service)
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-sm bg-blue rounded">
                                <i class="fe-aperture avatar-title font-22 text-white"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $service->appointements_count }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">{{ $service->nom }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        @endforeach

    </div>

    <div mt-3>
    {{ $this->table }}

    </div>
</div>
