<div>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">


                    <div class="d-flex align-items-start mt-3">
                        @if($consultation->temperature >= 37.5)
                            <i class="mdi mdi-thermometer-high text-danger font-18 me-2"></i>
                        @else
                        <i class="mdi mdi-trending-up me-2 font-18 text-primary"></i>
                        @endif
                        <div class="w-100">
                            <a class="mt-1 font-14 text-reset" href="javascript:void(0);">
                                <strong>Temperature: {{ $consultation->temperature }} ° C</strong>
                                <small class="text-muted"></small>
                            </a>
                        </div>
                    </div>


                    <div class="d-flex align-items-start mt-3">
                        <i class="mdi mdi-trending-up me-2 font-18 text-primary"></i>
                        <div class="w-100">
                            <a class="mt-1 font-14 text-reset" href="javascript:void(0);">
                                <strong>Tension: {{ $consultation->tension }} mgH</strong>
                                <small class="text-muted"></small>
                            </a>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div>
        </div>

        <div class="col-8">
            <div id="cardCollpase4" class="flex justify-content-between show">
                <div class="pt-3">
                    <div class="text-center">
                        <span class="text-2xl">{{ $consultation->imc }}</span>
                        @switch(true)
                            @case($consultation->imc < 18.5)
                            <span class="mdi mdi-thermometer-low text-danger font-18 me-2"></span>
                            @break
                            @case($consultation->imc >= 18.5 && $consultation->imc <= 24.9)
                            <span class="mdi mdi-thermometer font-18 text-primary"></span>
                            @break
                            @case($consultation->imc >= 25 && $consultation->imc <= 29.9)
                            <span class="mdi mdi-thermometer-high text-warning font-18 me-2"></span>
                            @break
                            @case($consultation->imc >= 30)
                            <span class="mdi mdi-thermometer-high text-danger font-18 me-2"></span>
                            @break
                            @default
                            <span class="mdi mdi-thermometer-high text-danger font-18 me-2"></span>
                        @endswitch

                    </div>
                    <div class="row text-center mt-2">
                        <div class="col-md-4">
                            <h3 class="fw-normal mt-3">
                                <span>{{ $consultation->poids }} Kg</span>
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <h3 class="fw-normal mt-3">
                                <span>{{ $age }} ans</span>
                            </h3>
                        </div>
                        <div class="col-md-4">
                            <h3 class="fw-normal mt-3">
                                <span>{{ $consultation->taille }} cm</span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
