import { Head, Link } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Users, ClipboardList, Activity, AlertTriangle, Printer } from 'lucide-react';
import AppLayout from '@/layouts/app-layout';
import { cetak as laporanCetak } from '@/routes/admin/laporan';

interface Props {
    stats: {
        totalSiswa: number;
        totalKonseling: number;
        totalMonitoring: number;
        totalPelanggaran: number;
    };
}

export default function LaporanIndex({ stats }: Props) {
    const statCards = [
        { title: 'Total Siswa', value: stats.totalSiswa, icon: Users, color: 'text-blue-600' },
        { title: 'Total Konseling', value: stats.totalKonseling, icon: ClipboardList, color: 'text-green-600' },
        { title: 'Total Monitoring', value: stats.totalMonitoring, icon: Activity, color: 'text-purple-600' },
        { title: 'Total Pelanggaran', value: stats.totalPelanggaran, icon: AlertTriangle, color: 'text-red-600' },
    ];

    const reportTypes = [
        { name: 'Laporan Konseling', jenis: 'konseling' },
        { name: 'Laporan Monitoring', jenis: 'monitoring' },
        { name: 'Laporan Pelanggaran', jenis: 'pelanggaran' },
        { name: 'Laporan Siswa', jenis: 'siswa' },
    ];

    return (
        <>
            <Head title="Laporan" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    {statCards.map((stat) => (
                        <Card key={stat.title}>
                            <CardHeader className="flex flex-row items-center justify-between pb-2">
                                <CardTitle className="text-sm font-medium text-muted-foreground">
                                    {stat.title}
                                </CardTitle>
                                <stat.icon className={`size-5 ${stat.color}`} />
                            </CardHeader>
                            <CardContent>
                                <div className="text-2xl font-bold">{stat.value}</div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <Card>
                    <CardHeader>
                        <CardTitle>Cetak Laporan</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid gap-4 md:grid-cols-2">
                            {reportTypes.map((report) => (
                                <Card key={report.jenis}>
                                    <CardContent className="flex items-center justify-between p-4">
                                        <div>
                                            <h3 className="font-medium">{report.name}</h3>
                                            <p className="text-sm text-muted-foreground">
                                                Cetak {report.name.toLowerCase()}
                                            </p>
                                        </div>
                                        <Button asChild>
                                            <Link href={laporanCetak.url({ query: { jenis: report.jenis } })}>
                                                <Printer className="mr-2 size-4" />
                                                Cetak
                                            </Link>
                                        </Button>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

LaporanIndex.layout = (page: React.ReactNode) => <AppLayout>{page}</AppLayout>;
