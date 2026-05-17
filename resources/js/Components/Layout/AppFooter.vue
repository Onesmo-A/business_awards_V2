<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { developerBrand } from '@/constants/developer'

const currentYear = new Date().getFullYear()
const page = usePage()

const visitorStats = computed(() => ({
    online: Number(page.props.visitorStats?.online ?? 0),
    today: Number(page.props.visitorStats?.today ?? 0),
    month: Number(page.props.visitorStats?.month ?? 0),
    total: Number(page.props.visitorStats?.total ?? 0),
}))
</script>

<template>
<footer class="bg-[#121212] border-t border-[#333] text-gray-400 py-12 mt-auto relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-[#D4AF37] to-transparent opacity-50"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <div>
                <Link href="/" class="flex items-center gap-2 mb-6">
                    <span class="text-2xl font-bold text-white">
                        Business<span class="text-[#D4AF37]"> Awards</span>
                    </span>
                </Link>

                <p class="text-sm leading-relaxed mb-6">
                    Recognizing and celebrating excellence in Business and Entrepreneurship.
                </p>
            </div>

            <div>
                <h3 class="text-white font-bold uppercase tracking-wider mb-6 text-sm border-b border-[#333] pb-2 inline-block">
                    Quick Links
                </h3>
                <ul class="space-y-3 text-sm">
                    <li><Link href="/" class="hover:text-[#D4AF37] transition-colors">Home</Link></li>
                    <li><Link href="/about" class="hover:text-[#D4AF37] transition-colors">About Us</Link></li>
                    <li><Link href="/categories" class="hover:text-[#D4AF37] transition-colors">Vote</Link></li>
                    <li><Link href="/participate" class="hover:text-[#D4AF37] transition-colors">Participate</Link></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold uppercase tracking-wider mb-6 text-sm border-b border-[#333] pb-2 inline-block">
                    Services
                </h3>
                <ul class="space-y-3 text-sm">
                    <li><Link href="/tickets" class="hover:text-[#D4AF37] transition-colors">Buy Tickets</Link></li>
                    <li><Link href="/sponsors" class="hover:text-[#D4AF37] transition-colors">Sponsors</Link></li>
                    <li><Link href="/contact" class="hover:text-[#D4AF37] transition-colors">Contact</Link></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold uppercase tracking-wider mb-6 text-sm border-b border-[#333] pb-2 inline-block">
                    Contact Us
                </h3>
                <ul class="space-y-4 text-sm">
                    <li>Dar es Salaam, Tanzania</li>
                    <li>
                        <a href="mailto:info@businessawards.co.tz" class="hover:text-[#D4AF37] transition-colors">
                            info@businessawards.co.tz
                        </a>
                    </li>
                    <li>
                        <a href="tel:+255652724557" class="hover:text-[#D4AF37] transition-colors">
                            +255 652 724 557
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mb-12">
            <h3 class="text-white font-bold uppercase tracking-wider mb-6 text-sm border-b border-[#333] pb-2 inline-block">
                Visitors Statistics
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-6 text-center hover:border-[#D4AF37] transition-all duration-300">
                    <p class="text-xs uppercase text-gray-400 mb-2">Online Now</p>
                    <h4 class="text-2xl font-bold text-white">{{ visitorStats.online.toLocaleString() }}</h4>
                </div>
                <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-6 text-center hover:border-[#D4AF37] transition-all duration-300">
                    <p class="text-xs uppercase text-gray-400 mb-2">Today</p>
                    <h4 class="text-2xl font-bold text-white">{{ visitorStats.today.toLocaleString() }}</h4>
                </div>
                <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-6 text-center hover:border-[#D4AF37] transition-all duration-300">
                    <p class="text-xs uppercase text-gray-400 mb-2">This Month</p>
                    <h4 class="text-2xl font-bold text-white">{{ visitorStats.month.toLocaleString() }}</h4>
                </div>
                <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-6 text-center hover:border-[#D4AF37] transition-all duration-300">
                    <p class="text-xs uppercase text-gray-400 mb-2">Total Visitors</p>
                    <h4 class="text-2xl font-bold text-white">{{ visitorStats.total.toLocaleString() }}</h4>
                </div>
            </div>
        </div>

        <div class="border-t border-[#333] pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <div class="flex flex-col md:flex-row items-center gap-4 text-center md:text-left">
                <p>&copy; {{ currentYear }} Business Awards. All rights reserved.</p>
                <span class="hidden md:inline text-[#333]">|</span>
                <div class="flex flex-col md:flex-row items-center gap-2">
                    <p class="font-medium text-gray-400">Designed & Developed by</p>
                    <a :href="developerBrand.websiteUrl" target="_blank" rel="noopener noreferrer" class="text-[#D4AF37] hover:underline font-semibold">
                        {{ developerBrand.name }}
                    </a>
                    <span class="text-[#555]">|</span>
                    <a :href="developerBrand.whatsappUrl" target="_blank" rel="noopener noreferrer" class="text-[#D4AF37] hover:underline">
                        {{ developerBrand.phoneDisplay }}
                    </a>
                </div>
            </div>

            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-[#D4AF37] transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-[#D4AF37] transition-colors">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>
</template>
