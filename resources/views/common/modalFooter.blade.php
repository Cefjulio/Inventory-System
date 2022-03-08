</div>
    <div class="modal-footer">
            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="
            modal">CLOSE</button>

            @if($selected_id < 1)
                <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal"
                >SAVE</button>

            @else
                <button type="button" wire:click.prevent="Update()" class="btn btn-dark close-modal"
                >UPDATE</button>

            @endif




            </div>
        </div>    
    </div>
</div>