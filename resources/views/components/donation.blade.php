<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/inventory/donate" class="mb-2">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Donate Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-2">
                        <label class="text-secondary">Item</label>
                        <select class="form-select" name="item_id">
                            @foreach($items as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="text-secondary">Quantity</label>
                        <input min="1" class="form-control" type="number" name="quantity">
                    </div>

                    <div class="form-group mb-2">
                        <label class="text-secondary">Recipient</label>
                        <select name="recipient_id" class="form-select">
                            @foreach($recipients as $recipient)
                                <option value="{{$recipient->id}}">{{$recipient->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
