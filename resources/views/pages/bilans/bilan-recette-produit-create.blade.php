<x-default-layout>
    <div id="message" class="mt-10"></div>
    <form  id="form" method="POST" action="{{  route('bilan-produit-recette-store') }}" data-redirect="{{ route('bilan-produit-recette') }}" enctype="multipart/form-data">
        @csrf
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
           <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Bilan produits et recette</h3>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body pb-10">
                    <div class="table-responsive">
                        <table   class="table table-row-dashed table-row-gray-300 gy-3 table-rounded table-striped border gy-3 gs-3">
                            <thead class="bg-secondary text-align-center">
                                <tr class="fw-bold fs-6 text-gray-800" >
                                    <th class="w-30px">#</th>
                                    <th class="w-300px">Recette</th>
                                    <th class="w-300px">Quantité vendue</th>
                                </tr>
                            </thead>
                            <tbody id="tabpanier-id" >
                                @foreach ($recettes as $recette)
                                    <tr>
                                        <input type="hidden" name="recettes[]" value="{{ $recette->id }}">
                                        <td class="w-30px">{{ $loop->iteration }}</td>
                                        <td class="w-300px">{{ $recette->name }}</td>
                                        <td class="w-200px"><input type="number" min="0" name="quantity[]" value="0"  class="form-control  h-35px p-1 rounded-0" ></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
           </div>
           <div class="d-flex justify-content-end mt-5">
              <button type="submit" id="btn-save-submit" class="btn btn-primary">
              <span class="indicator-label">ENREGISTRER</span>
              <span class="indicator-progress">Veuillez patienter...
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              </button>
           </div>
        </div>
     </form>
</x-default-layout>
