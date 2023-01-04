<div>
    <span>RESUME #{{ $record->appointement->id }}</span>
    <table class="table">
        <tr>
            <td>Medicament</td>
            <td>Prix</td>
            <td>Quantité</td>
        </tr>
        @foreach($record->ligne_ordonances as $ligne)
            <tr>
                <td>{{ $ligne->medicament->nom }}</td>
                <td>{{ $ligne->medicament->prix }}</td>
                <td>x{{ $ligne->quantite }}</td>
            </tr>
        @endforeach
    </table>
</div>
