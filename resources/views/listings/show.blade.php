<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="mb-12">
                <h2 class="text-2xl font-medium text-gray-900 title-font">
                    {{ $listing->title }}
                </h2>
                <div class="md:flex-grow mr-8 mt-2 flex items-center justify-start">
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
            </div>
            <div class="my-6">
                <div class="flex flex-wrap md:flex-nowrap">
                    <div class="content w-full pr-4 leading-relaxed text-base">
                        {!! $listing->content !!}
                    </div>
                </div>
            </div>
            <div class="my-6">
                <div class="flex flex-wrap md:flex-nowrap">
                    <div class="content w-full pr-4 leading-relaxed text-base">
                        <img
                                src="/storage/{{ $listing->logo }}"
                                alt="{{ $listing->company }} logo"
                                class="max-w-full mb-4">
                        <p class="leading-relaxed text-base">
                            <b>Location: </b>{{ $listing->location }}<br>
                            <b>Company: </b>{{ $listing->company }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
