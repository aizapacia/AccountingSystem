<div>
    <div style="background: white; margin-top: 100px;" class="p-3">
      <div class="d-flex justify-content-center">
      <div class="input-group mb-3">
        <select class="pick-search" wire:model="searchby">
          <option value="distributor" selected>Distributor</option>
          <option value="order">Order</option>
        </select>
        @if($searchby == 'order')
        <input type="text" placeholder="Enter order ID" class="form-control" aria-label="Text input with dropdown button">
        @else
        <select class="form-select form-control">
          <option disabled selected>Select Distributor Name</option>
        </select>
        @endif
      </div>
        <button class="btn btn-s btn-primary ms-3">Search </button>
    </div>
</div>
