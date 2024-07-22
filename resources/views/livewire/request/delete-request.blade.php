<div>
    <x-mary-modal
        wire:model="deleteRequestModal"
        class="backdrop-blur"
        title="Are you sure?"
    >
        <div>Click "cancel" or press ESC to exit.</div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.deleteRequestModal = false"
            />
            <x-mary-button
                label="Confirm"
                class="bg-red-500 text-white hover:bg-red-600"
                type="submit"
                @click="$wire.delete"
                spinner="delete"
            />
        </x-slot:actions>
    </x-mary-modal>
</div>
