<x-app-layout>
    <section class="container px-5 py-12 mx-auto">
        <div class="mb-12">
            <h2 class="text-2xl font-medium text-gray-900 title-font px-4">All jobs found ({{ $listings->count() }})</h2>
        </div>
        <div class="-my-6">
            @foreach($listings as $listing)
                <a href="#" class="border-gray-900 py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100
                        {{ $listing->is_highlighted ?
                        'bg-green-100 hover:bg-green-200' : 'bg-yellow hover:bg-yellow-100' }}">
                    <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                        <img src="/storage/{{ $listing->logo }}" alt="{{ $listing->company }} logo"
                             class="w-16 h-16 rounded-full object-cover">
                    </div>
                    <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                        <h2 class="text-xl font-bold text-gray-900 title-font mb-1">{{ $listing->title }}</h2>
                        <div> {!! strip_tags(substr($listing->content, 0, 200)) !!}  ......</div>
                        <p class="leading-relaxed text-gray-900">
                            {{ $listing->company }} &mdash; <span class="text-gray-600">{{ $listing->location }}</span>
                        </p>
                    </div>
                    <div class="md:flex-grow mr-8 flex items-center justify-start">
                        @foreach($listing->tags as $index => $tag)
                            @if($index%2 == 0)
                                <span class="bg-red-100 text-red-800 text-xs font-semibold
                                 mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">{{ $tag->name }}</span>
                            @elseif($index%2 == 1)
                                <span class=" bg-green-100 text-green-800 text-xs font-semibold
                                mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">{{ $tag->name }}</span>
                            @endif
                        @endforeach
                    </div>
                    <span class="md:flex-grow flex items-center justify-end">
                    <span>posted {{ $listing->created_at->diffForHumans() }}</span>
                </span>
                </a>
            @endforeach
        </div>
    </section>
</x-app-layout>
