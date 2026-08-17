import { Head } from '@inertiajs/react';
import { Users, ClipboardList, AlertTriangle } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';

type DashboardProps = {
    stats: {
        totalSiswa: number;
        totalKonseling: number;
        totalPelanggaran: number;
    };
};

export default function Dashboard({ stats }: DashboardProps) {
    const statCards = [
        { title: 'Total Siswa', value: stats.totalSiswa, icon: Users, color: 'text-blue-600', bg: 'bg-blue-50 dark:bg-blue-950/30' },
        { title: 'Total Konseling', value: stats.totalKonseling, icon: ClipboardList, color: 'text-green-600', bg: 'bg-green-50 dark:bg-green-950/30' },
        { title: 'Total Pelanggaran', value: stats.totalPelanggaran, icon: AlertTriangle, color: 'text-red-600', bg: 'bg-red-50 dark:bg-red-950/30' },
    ];

    return (
        <>
            <Head title="Dashboard Kepala Sekolah" />
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
                <div className="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                    <div className="flex h-full items-center justify-center p-4">
                        <div className="text-center">
                            <h2 className="text-lg font-semibold">Laporan Bimbingan Konseling</h2>
                            <p className="mt-1 text-sm text-muted-foreground">
                                Gunakan menu Laporan di sidebar untuk melihat data lengkap.
                            </p>
                        </div>
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
