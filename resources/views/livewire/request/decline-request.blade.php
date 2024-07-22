<div>
    <x-mary-modal
        wire:model="declineRequestModal"
        class="backdrop-blur"
        title="Are you sure you want to decline this request?"
    >
        <div>Click "cancel" or press ESC to exit.</div>

        <x-slot:actions>
            <x-mary-button
                label="Cancel"
                @click="$wire.declineRequestModal = false"
            />
            <x-mary-button
                label="Confirm"
                class="bg-gray-800 text-white hover:bg-gray-900"
                type="submit"
                @click="$wire.declineRequest"
                spinner="declineRequest"
            />
        </x-slot:actions>
    </x-mary-modal>
</div>
