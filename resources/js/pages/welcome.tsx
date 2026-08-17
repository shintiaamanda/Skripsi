import { Head, Link, usePage } from '@inertiajs/react';
import { dashboard, login } from '@/routes';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Calendar, Info, ShieldCheck, LogIn, LayoutDashboard } from 'lucide-react';
import { formatDate } from '@/utils/date';

interface Jadwal {
    id_jadwal: number;
    hari: string;
    tanggal_layanan: string;
    jam: string;
    guru: string;
}

interface Informasi {
    id_info: number;
    informasi: string;
    tanggal_informasi: string;
}

interface TataTertib {
    id_tertib: number;
    tata_tertib: string;
    tanggal_konseling: string;
}

interface PageProps {
    auth: { user: unknown };
    jadwal: Jadwal[];
    informasi: Informasi[];
    tataTertib: TataTertib[];
    [key: string]: unknown;
}

export default function Welcome() {
    const { auth, jadwal, informasi, tataTertib } = usePage<PageProps>().props;

    return (
        <>
            <Head title="SIBk - Sistem Informasi Bimbingan Konseling" />
            <div className="min-h-screen bg-background">
                <header className="sticky top-0 z-50 border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
                    <div className="container mx-auto flex h-16 items-center justify-between px-4">
                        <div className="flex items-center gap-3">
                            <div className="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-primary-foreground">
                                <ShieldCheck className="h-5 w-5" />
                            </div>
                            <div>
                                <h1 className="text-lg font-semibold leading-tight">SIBk</h1>
                                <p className="text-xs text-muted-foreground">SMKN 3 Padang</p>
                            </div>
                        </div>
                        <nav className="flex items-center gap-3">
                            {auth.user ? (
                                <Link
                                    href={dashboard()}
                                    className="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                                >
                                    <LayoutDashboard className="h-4 w-4" />
                                    Dashboard
                                </Link>
                            ) : (
                                <Link
                                    href={login()}
                                    className="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
                                >
                                    <LogIn className="h-4 w-4" />
                                    Masuk
                                </Link>
                            )}
                        </nav>
                    </div>
                </header>

                <main className="container mx-auto px-4 py-8">
                    <div className="mb-10 text-center">
                        <h2 className="text-3xl font-bold tracking-tight">
                            Sistem Informasi Bimbingan Konseling
                        </h2>
                        <p className="mt-2 text-muted-foreground">
                            SMKN 3 Padang — Informasi layanan bimbingan konseling untuk siswa dan orang tua
                        </p>
                    </div>

                    <div className="grid gap-8 lg:grid-cols-3">
                        <Card className="lg:col-span-2">
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <Calendar className="h-5 w-5 text-primary" />
                                    Jadwal Layanan BK
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                {jadwal.length === 0 ? (
                                    <p className="py-8 text-center text-muted-foreground">
                                        Belum ada jadwal layanan.
                                    </p>
                                ) : (
                                    <Table>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>Hari</TableHead>
                                                <TableHead>Tanggal</TableHead>
                                                <TableHead>Jam</TableHead>
                                                <TableHead>Guru BK</TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            {jadwal.map((item) => (
                                                <TableRow key={item.id_jadwal}>
                                                    <TableCell className="font-medium">
                                                        <Badge variant="outline">{item.hari}</Badge>
                                                    </TableCell>
                                                    <TableCell>{formatDate(item.tanggal_layanan)}</TableCell>
                                                    <TableCell>{item.jam}</TableCell>
                                                    <TableCell>{item.guru}</TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                )}
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <Info className="h-5 w-5 text-primary" />
                                    Informasi BK
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                {informasi.length === 0 ? (
                                    <p className="py-8 text-center text-muted-foreground">
                                        Belum ada informasi.
                                    </p>
                                ) : (
                                    <div className="space-y-4">
                                        {informasi.map((item) => (
                                            <div
                                                key={item.id_info}
                                                className="rounded-lg border p-4"
                                            >
                                                <p className="text-sm">{item.informasi}</p>
                                                <p className="mt-2 text-xs text-muted-foreground">
                                                    {formatDate(item.tanggal_informasi)}
                                                </p>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>

                    <div className="mt-8">
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <ShieldCheck className="h-5 w-5 text-primary" />
                                    Tata Tertib Sekolah
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                {tataTertib.length === 0 ? (
                                    <p className="py-8 text-center text-muted-foreground">
                                        Belum ada tata tertib.
                                    </p>
                                ) : (
                                    <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                        {tataTertib.map((item) => (
                                            <div
                                                key={item.id_tertib}
                                                className="rounded-lg border p-4 transition-colors hover:bg-muted/50"
                                            >
                                                <p className="text-sm font-medium whitespace-pre-wrap break-words">
                                                    {item.tata_tertib}
                                                </p>
                                                <p className="mt-2 text-xs text-muted-foreground">
                                                    {formatDate(item.tanggal_konseling)}
                                                </p>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>
                </main>

                <footer className="mt-12 border-t py-6 text-center text-sm text-muted-foreground">
                    &copy; {new Date().getFullYear()} SIBk — SMKN 3 Padang. All rights reserved.
                </footer>
            </div>
        </>
    );
}
