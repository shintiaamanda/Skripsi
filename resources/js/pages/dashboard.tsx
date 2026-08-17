import { Head, Link } from '@inertiajs/react';
import { Users, ClipboardList, FileText, Shield, Calendar, UserCircle, ArrowRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import adminRoutes from '@/routes/admin';
import { formatDate } from '@/utils/date';

interface Stats {
    totalSiswa: number;
    totalKonseling: number;
    totalMonitoring: number;
    totalPelanggaran: number;
    totalPengajuan: number;
    totalAkun: number;
}

interface KonselingItem {
    id_data_konseling: number;
    siswa: { nama: string } | null;
    tanggal: string;
    masalah: string;
}

interface PelanggaranItem {
    id_pelanggaran: number;
    siswa: { nama: string } | null;
    tanggal_pelanggaran: string;
    poin: number;
    tindakan: string;
}

interface PengajuanItem {
    id_konseling: number;
    siswa: { nama: string } | null;
    tanggal_konseling: string;
    keluhan: string;
}

interface Props {
    stats: Stats;
    konselingTerbaru: KonselingItem[];
    pelanggaranTerbaru: PelanggaranItem[];
    pengajuanTerbaru: PengajuanItem[];
}

export default function Dashboard({ stats, konselingTerbaru, pelanggaranTerbaru, pengajuanTerbaru }: Props) {
    const statCards = [
        { title: 'Total Siswa', value: stats.totalSiswa, icon: Users, color: 'text-blue-600', bg: 'bg-blue-50 dark:bg-blue-950/30' },
        { title: 'Total Konseling', value: stats.totalKonseling, icon: ClipboardList, color: 'text-green-600', bg: 'bg-green-50 dark:bg-green-950/30' },
        { title: 'Total Monitoring', value: stats.totalMonitoring, icon: FileText, color: 'text-purple-600', bg: 'bg-purple-50 dark:bg-purple-950/30' },
        { title: 'Total Pelanggaran', value: stats.totalPelanggaran, icon: Shield, color: 'text-red-600', bg: 'bg-red-50 dark:bg-red-950/30' },
        { title: 'Pengajuan Konseling', value: stats.totalPengajuan, icon: Calendar, color: 'text-orange-600', bg: 'bg-orange-50 dark:bg-orange-950/30' },
        { title: 'Total Akun', value: stats.totalAkun, icon: UserCircle, color: 'text-cyan-600', bg: 'bg-cyan-50 dark:bg-cyan-950/30' },
    ];

    return (
        <>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    {statCards.map((card) => (
                        <div
                            key={card.title}
                            className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                        >
                            <div className={`absolute inset-0 flex items-center justify-center gap-3 ${card.bg}`}>
                                <card.icon className={`size-8 ${card.color}`} />
                                <div>
                                    <p className="text-2xl font-bold">{card.value}</p>
                                    <p className="text-sm text-muted-foreground">{card.title}</p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Pengajuan Konseling dari Siswa */}
                {pengajuanTerbaru.length > 0 && (
                    <div className="relative overflow-hidden rounded-xl border border-orange-200 bg-orange-50/50 p-4 dark:border-orange-800/50 dark:bg-orange-950/20">
                        <div className="mb-3 flex items-center justify-between">
                            <div className="flex items-center gap-2">
                                <Calendar className="size-5 text-orange-600" />
                                <h2 className="text-lg font-semibold">Pengajuan Konseling Baru dari Siswa</h2>
                                <span className="rounded-full bg-orange-500 px-2 py-0.5 text-xs font-bold text-white">
                                    {pengajuanTerbaru.length}
                                </span>
                            </div>
                            <Button variant="ghost" size="sm" asChild className="text-orange-600 hover:text-orange-700">
                                <Link href={adminRoutes.pengajuan.index.url()}>
                                    Lihat Semua
                                    <ArrowRight className="ml-1 size-4" />
                                </Link>
                            </Button>
                        </div>
                        <div className="space-y-2">
                            {pengajuanTerbaru.map((item) => (
                                <div key={item.id_konseling} className="flex items-center justify-between rounded-lg border border-orange-200 bg-white p-3 dark:border-orange-800/40 dark:bg-orange-950/30">
                                    <div className="flex-1">
                                        <p className="font-medium">{item.siswa?.nama ?? '-'}</p>
                                        <p className="mt-0.5 text-sm text-muted-foreground line-clamp-1">{item.keluhan}</p>
                                    </div>
                                    <div className="ml-4 flex items-center gap-3">
                                        <span className="text-xs text-muted-foreground">{formatDate(item.tanggal_konseling)}</span>
                                        <Button variant="default" size="sm" asChild>
                                            <Link href={adminRoutes.pengajuan.show.url(item.id_konseling)}>
                                                Proses
                                            </Link>
                                        </Button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}

                <div className="grid min-h-[100vh] gap-4 md:min-h-min lg:grid-cols-2">
                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 className="mb-3 text-lg font-semibold">Konseling Terbaru</h2>
                        {konselingTerbaru.length > 0 ? (
                            <div className="space-y-2">
                                {konselingTerbaru.map((item) => (
                                    <div key={item.id_data_konseling} className="flex items-center justify-between rounded-lg border p-3">
                                        <div>
                                            <p className="font-medium">{item.siswa?.nama ?? '-'}</p>
                                            <p className="text-sm text-muted-foreground line-clamp-1">{item.masalah}</p>
                                        </div>
                                        <span className="shrink-0 text-xs text-muted-foreground">{formatDate(item.tanggal)}</span>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="py-8 text-center text-sm text-muted-foreground">Belum ada data konseling.</p>
                        )}
                    </div>

                    <div className="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                        <h2 className="mb-3 text-lg font-semibold">Pelanggaran Terbaru</h2>
                        {pelanggaranTerbaru.length > 0 ? (
                            <div className="space-y-2">
                                {pelanggaranTerbaru.map((item) => (
                                    <div key={item.id_pelanggaran} className="flex items-center justify-between rounded-lg border p-3">
                                        <div>
                                            <p className="font-medium">{item.siswa?.nama ?? '-'}</p>
                                            <p className="text-sm text-muted-foreground line-clamp-1">{item.tindakan}</p>
                                        </div>
                                        <span className="shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                            {item.poin} poin
                                        </span>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <p className="py-8 text-center text-sm text-muted-foreground">Belum ada data pelanggaran.</p>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
}

Dashboard.layout = (page: React.ReactNode) => (
    <AppLayout breadcrumbs={[{ title: 'Dashboard', href: dashboard() }]}>
        {page}
    </AppLayout>
);
