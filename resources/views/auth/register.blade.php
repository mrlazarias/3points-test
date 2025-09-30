<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Registro - 3Pontos Community</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="background-color: #111827; color: #f9fafb; min-height: 100vh">
        <!-- Header -->
        <header style="background-color: #1f2937; border-bottom: 1px solid #374151; padding: 1rem 1.5rem">
            <div
                style="
                    max-width: 80rem;
                    margin: 0 auto;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                "
            >
                <div style="display: flex; align-items: center; gap: 1rem">
                    <a
                        href="/"
                        style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit"
                    >
                        <div
                            style="
                                width: 2rem;
                                height: 2rem;
                                background-color: #f97316;
                                border-radius: 0.5rem;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            "
                        >
                            <span style="color: white; font-weight: bold; font-size: 0.875rem">3P</span>
                        </div>
                        <span style="font-size: 1.25rem; font-weight: 600">3Pontos</span>
                        <span style="color: #9ca3af; font-size: 0.875rem">Community</span>
                    </a>
                </div>
            </div>
        </header>

        <div
            style="
                min-height: calc(100vh - 80px);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1.5rem;
            "
        >
            <div style="width: 100%; max-width: 400px">
                <!-- Register Card -->
                <div
                    style="background-color: #1f2937; border: 1px solid #374151; border-radius: 0.75rem; padding: 2rem"
                >
                    <div style="text-align: center; margin-bottom: 2rem">
                        <h1 style="font-size: 1.5rem; font-weight: bold; margin: 0 0 0.5rem 0">Criar conta</h1>
                        <p style="color: #9ca3af; margin: 0">Junte-se à nossa comunidade</p>
                    </div>

                    @if ($errors->any())
                        <div
                            style="
                                background-color: #dc2626;
                                border: 1px solid #ef4444;
                                border-radius: 0.5rem;
                                padding: 1rem;
                                margin-bottom: 1.5rem;
                            "
                        >
                            <div style="display: flex; align-items: center; gap: 0.5rem">
                                <svg
                                    style="width: 1.25rem; height: 1.25rem; color: white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    ></path>
                                </svg>
                                <span style="color: white; font-weight: 500">Erro no registro</span>
                            </div>
                            <ul style="color: white; font-size: 0.875rem; margin: 0.5rem 0 0 0; padding-left: 1.25rem">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div style="margin-bottom: 1.5rem">
                            <label
                                for="name"
                                style="
                                    display: block;
                                    color: #e5e7eb;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    margin-bottom: 0.5rem;
                                "
                            >
                                Nome completo
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background-color: #374151;
                                    border: 1px solid #4b5563;
                                    border-radius: 0.5rem;
                                    color: #f9fafb;
                                    font-size: 0.875rem;
                                    transition: border-color 0.2s;
                                "
                                onfocus="this.style.borderColor='#60a5fa'"
                                onblur="this.style.borderColor='#4b5563'"
                            />
                        </div>

                        <!-- Username -->
                        <div style="margin-bottom: 1.5rem">
                            <label
                                for="username"
                                style="
                                    display: block;
                                    color: #e5e7eb;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    margin-bottom: 0.5rem;
                                "
                            >
                                Nome de usuário
                            </label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background-color: #374151;
                                    border: 1px solid #4b5563;
                                    border-radius: 0.5rem;
                                    color: #f9fafb;
                                    font-size: 0.875rem;
                                    transition: border-color 0.2s;
                                "
                                onfocus="this.style.borderColor='#60a5fa'"
                                onblur="this.style.borderColor='#4b5563'"
                                placeholder="Escolha um nome único"
                            />
                            <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.25rem 0 0 0">
                                Este será seu nome público na comunidade (u/nomeusuario)
                            </p>
                        </div>

                        <!-- Email -->
                        <div style="margin-bottom: 1.5rem">
                            <label
                                for="email"
                                style="
                                    display: block;
                                    color: #e5e7eb;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    margin-bottom: 0.5rem;
                                "
                            >
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background-color: #374151;
                                    border: 1px solid #4b5563;
                                    border-radius: 0.5rem;
                                    color: #f9fafb;
                                    font-size: 0.875rem;
                                    transition: border-color 0.2s;
                                "
                                onfocus="this.style.borderColor='#60a5fa'"
                                onblur="this.style.borderColor='#4b5563'"
                            />
                        </div>

                        <!-- Password -->
                        <div style="margin-bottom: 1.5rem">
                            <label
                                for="password"
                                style="
                                    display: block;
                                    color: #e5e7eb;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    margin-bottom: 0.5rem;
                                "
                            >
                                Senha
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background-color: #374151;
                                    border: 1px solid #4b5563;
                                    border-radius: 0.5rem;
                                    color: #f9fafb;
                                    font-size: 0.875rem;
                                    transition: border-color 0.2s;
                                "
                                onfocus="this.style.borderColor='#60a5fa'"
                                onblur="this.style.borderColor='#4b5563'"
                            />
                        </div>

                        <!-- Password Confirmation -->
                        <div style="margin-bottom: 1.5rem">
                            <label
                                for="password_confirmation"
                                style="
                                    display: block;
                                    color: #e5e7eb;
                                    font-size: 0.875rem;
                                    font-weight: 500;
                                    margin-bottom: 0.5rem;
                                "
                            >
                                Confirmar senha
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                style="
                                    width: 100%;
                                    padding: 0.75rem;
                                    background-color: #374151;
                                    border: 1px solid #4b5563;
                                    border-radius: 0.5rem;
                                    color: #f9fafb;
                                    font-size: 0.875rem;
                                    transition: border-color 0.2s;
                                "
                                onfocus="this.style.borderColor='#60a5fa'"
                                onblur="this.style.borderColor='#4b5563'"
                            />
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            style="
                                width: 100%;
                                padding: 0.75rem;
                                background-color: #16a34a;
                                color: white;
                                border: none;
                                border-radius: 0.5rem;
                                font-size: 0.875rem;
                                font-weight: 500;
                                cursor: pointer;
                                transition: background-color 0.2s;
                            "
                            onmouseover="this.style.backgroundColor='#15803d'"
                            onmouseout="this.style.backgroundColor='#16a34a'"
                        >
                            Criar conta
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div
                        style="
                            text-align: center;
                            margin-top: 1.5rem;
                            padding-top: 1.5rem;
                            border-top: 1px solid #374151;
                        "
                    >
                        <p style="color: #9ca3af; font-size: 0.875rem; margin: 0">
                            Já tem uma conta?
                            <a
                                href="{{ route('login') }}"
                                style="color: #60a5fa; text-decoration: none; font-weight: 500"
                                onmouseover="this.style.textDecoration='underline'"
                                onmouseout="this.style.textDecoration='none'"
                            >
                                Fazer login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
