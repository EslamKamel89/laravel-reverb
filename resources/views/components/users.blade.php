<ul x-cloak x-data="users" x-show="open">
    <template x-for="user in users">
        <li>
            <span class="flex items-center px-4 py-1 rounded-md gap-x-2 hover:bg-fuchsia-900 hover:text-white">
                <span class="relative">
                    <img :src="user.avatar" :alt="user.name" class="w-6 h-6 rounded-md" />

                    <span class="absolute -bottom-1 -right-1">
                        <span class="flex h-3.5 w-3.5 items-center justify-center rounded-full bg-sidebar">
                            <span class="flex w-2 h-2 border rounded-full" :class="{
                                'bg-green-500 border-green-600':user.online ,
                                'border-gray-400 bg-sidebar' : !user.online
                                }"></span>
                        </span>
                    </span>
                </span>

                <span x-text="user.name"></span>
            </span>
        </li>
    </template>
</ul>

@script
<script>
Alpine.data('users', () => {
    return {
        users: @js($users),
        init() {
            Echo.join('workspace')
                .here((users) => this.markOnline(users))
                .joining((user) => this.markOnline([user]))
                .leaving((user) => this.markOffline([user]))
        },
        markOnline(users) {
            users.forEach((user) => {
                this.users.find((u) => u.id === user.id).online = true
            })
        },
        markOffline(users) {
            users.forEach((user) => {
                this.users.find((u) => u.id === user.id).online = false
            })
        },
    }
});
</script>
@endscript