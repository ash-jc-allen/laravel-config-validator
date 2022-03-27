<div class="my-1 mx-2">
    <div class="bg-red-700 text-white font-bold px-1 mb-1">Config validation failed!</div>

    <div class="mb-1"><b>{{ count($allErrors) }} errors</b> found on your application:</div>
    <div class="space-y-1">
        @foreach ($allErrors as $configField => $errors)
            <div>
                <div>
                    <span class="text-yellow font-bold">{{ $configField }}</span>
                    <span class="ml-2">
                        Value:
                        @if (config($configField))
                            <b>{{ config($configField) }}</b>
                        @else
                            <i class="text-gray-400">[empty field]</i>
                        @endif
                    </span>
                </div>
                @foreach ($errors as $error)
                    <div class="ml-2 text-gray-500">⇁ {{ $error }}</div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
