import { dashboard, login, register } from '@/routes';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

const actionLinks = [
    {
        title: 'Read the Documentation',
        href: 'https://laravel.com/docs',
    },
    {
        title: 'Watch Laracasts Tutorials',
        href: 'https://laracasts.com',
    },
];

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link
                    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
                    rel="stylesheet"
                />
            </Head>
            <div className="min-h-screen bg-[#fdfdfc] text-[#1b1b18] transition-colors dark:bg-[#0a0a0a] dark:text-[#ededec]">
                <header className="mx-auto flex w-full max-w-5xl justify-end px-6 py-6">
                    <nav className="flex items-center gap-4 text-sm">
                        {auth.user ? (
                            <Link
                                href={dashboard().url}
                                className="rounded-sm border border-[#19140035] px-5 py-1.5 leading-normal hover:border-[#1915014a] dark:border-[#3e3e3a] dark:hover:border-[#62605b]"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={login().url}
                                    className="rounded-sm border border-transparent px-5 py-1.5 leading-normal hover:border-[#19140035] dark:hover:border-[#3e3e3a]"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={register().url}
                                    className="rounded-sm border border-[#19140035] px-5 py-1.5 leading-normal hover:border-[#1915014a] dark:border-[#3e3e3a] dark:hover:border-[#62605b]"
                                >
                                    Register
                                </Link>
                            </>
                        )}
                    </nav>
                </header>

                <main className="mx-auto flex max-w-5xl flex-col items-center gap-8 px-6 pb-16 text-sm lg:flex-row">
                    <section className="flex w-full flex-1 flex-col gap-4 rounded-xl border border-[#1a1a0014] bg-white p-8 shadow-sm dark:border-[#fffaed2d] dark:bg-[#161615]">
                        <h1 className="text-xl font-semibold">Website Posting Dasi</h1>
                        <p className="text-[#706f6c] dark:text-[#a1a09a]">
                            Mulai perjalanan edukasi seputar tata cara dan etika memakai dasi. Berikut beberapa
                            langkah singkat untuk memulai.
                        </p>
                        <ul className="space-y-3">
                            {actionLinks.map((item) => (
                                <li key={item.href}>
                                    <a
                                        href={item.href}
                                        target="_blank"
                                        rel="noreferrer"
                                        className="inline-flex items-center gap-2 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#ff4433]"
                                    >
                                        {item.title}
                                        <svg
                                            aria-hidden="true"
                                            className="h-2.5 w-2.5"
                                            viewBox="0 0 10 11"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001"
                                                stroke="currentColor"
                                                strokeLinecap="square"
                                            />
                                        </svg>
                                    </a>
                                </li>
                            ))}
                        </ul>
                        <div className="pt-4">
                            <Link
                                href={auth.user ? dashboard().url : register().url}
                                className="inline-flex items-center gap-2 rounded-md bg-[#1b1b18] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#2b2b26] dark:bg-[#ededec] dark:text-[#0a0a0a] dark:hover:bg-white"
                            >
                                {auth.user ? 'Masuk ke Dashboard' : 'Mulai Sekarang'}
                            </Link>
                        </div>
                    </section>

                    <section className="flex w-full max-w-sm flex-col gap-4 rounded-xl border border-[#1a1a0014] bg-white p-8 text-center shadow-sm dark:border-[#fffaed2d] dark:bg-[#161615]">
                        <h2 className="text-lg font-semibold">Tentang Platform</h2>
                        <p className="text-sm text-[#706f6c] dark:text-[#a1a09a]">
                            Admin dapat mengelola video, foto, narasi, dan materi edukasi yang akan ditampilkan ke
                            publik. Pengunjung dapat mengajukan konsultasi secara mudah melalui halaman publik kami.
                        </p>
                    </section>
                </main>
            </div>
        </>
    );
}