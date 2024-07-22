<div>
    <x-mary-modal
        wire:model="approveRequestModal"
        class="backdrop-blur"
        title="Are you sure you want to approve this request?"
    >
        <div>Click "cancel" or press ESC to exit.</div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.approveRequestModal = false"
            />
            <x-mary-button
                label="Confirm"
                class="bg-emerald-500 text-white hover:bg-emerald-600"
                type="submit"
                @click="$wire.approveRequest"
                spinner="approveRequest"
            />
        </x-slot:actions>
    </x-mary-modal>
</div>
