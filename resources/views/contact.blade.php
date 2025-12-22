<x-layout>
    <x-slot:title>
        Contact - Laravel Posts App
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Contactez-nous</h1>
            
            <p class="text-gray-600 mb-8 leading-relaxed">
                Vous avez des questions ou des suggestions ? N'hésitez pas à nous contacter en utilisant le formulaire ci-dessous.
            </p>

            <form class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <input type="text" id="name" name="name" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border placeholder-gray-400"
                        placeholder="Votre nom">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                    <input type="email" id="email" name="email" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border placeholder-gray-400"
                        placeholder="votre@email.com">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="5" 
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2.5 border placeholder-gray-400"
                        placeholder="Comment pouvons-nous vous aider ?"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                        class="inline-flex justify-center py-2.5 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Envoyer le message
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
