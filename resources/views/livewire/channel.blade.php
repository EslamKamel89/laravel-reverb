<?php

use App\Models\Channel;

use function Livewire\Volt\mount;
use function Livewire\Volt\state;

state(['channel', 'channelId', 'messages', 'subscribed']);

mount(function (Channel $channel) {
    $this->channelId = $this->channel->id;
    $this->messages = $this->channel->getMessages()->toArray();
    $this->subscribed = $this->channel->isSubscribed(auth()->user());
});

$join = fn () => ($this->subscribed = $this->channel->subscribe(auth()->user()));

$send = fn (string $message) => $this->channel->send(auth()->user(), $message);

?>

<div x-data="channel" class="flex flex-col justify-between w-full h-full p-4 pb-2" style="height: calc(100vh - 100px)">
    <div class="flex flex-col h-full mb-4 overflow-y-scroll messages grow" x-ref="messages">
        <span class="w-full py-4 mt-auto text-lg text-center" :class="{ 'mb-4 border-b': $wire.messages.length > 0 }">
            This is the very beginning of the
            <strong>{{ $channel->name }}</strong>
            channel.
        </span>

        <template x-for="message in $wire.messages">
            <div class="flex gap-x-2">
                <img :src="message.user.avatar" :alt="message.user.name" class="w-10 h-10 rounded-md" />

                <div>
                    <div class="flex items-center gap-x-2">
                        <span class="text-lg font-bold" x-text="message.user.name"></span>

                        <time class="text-sm text-gray-600" x-text="message.sent_at"></time>
                    </div>

                    <div x-html="message.content" class="text-lg"></div>
                </div>
            </div>
        </template>
    </div>

    <div class="flex w-full" @submitted.stop="send($event.detail.message)">
        @if ($subscribed)
        <div class="flex flex-col w-full gap-y-1">
            <x-editor channel="{{ $channel->name }}" />

            <!-- Typing Indicator -->
            <span class="block shrink-0 text-xs text-gray-500 after:content-['\200b']"></span>
        </div>
        @else
        <div class="flex flex-col items-center justify-center flex-grow p-6 bg-gray-100 border rounded-md gap-y-4">
            <span class="text-lg font-bold">
                #{{ $channel->name }}
            </span>

            <button type="submit" class="px-4 py-2 text-base text-white bg-green-800 rounded-md" wire:click="join">
                Join channel
            </button>
        </div>
        @endif
    </div>
</div>

@script
<script>
Alpine.data('channel', () => {
    return {
        isTyping: false,

        usersTyping: [],

        channel: null,

        init() {
            this.scrollPosition()
            this.channel = Echo.private('channels.' + this.$wire.channelId);
            this.channel.listen('MessageSent', (event) => {
                pr(event, 'MessageSent event received')
                this.$wire.messages.push(event.message);
            })
        },

        send(message) {
            this.$wire.send(message)
        },

        scrollPosition() {
            this.$watch('$wire.messages', () => {
                this.$refs.messages.scrollTop =
                    this.$refs.messages.scrollHeight;
            });
        },
    }
})
</script>
@endscript
