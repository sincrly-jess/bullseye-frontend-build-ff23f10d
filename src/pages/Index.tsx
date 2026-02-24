import Navbar from "@/components/Navbar";
import HeroSection from "@/components/HeroSection";
import GamesSection from "@/components/GamesSection";
import LeaderboardSection from "@/components/LeaderboardSection";
import FeaturesSection from "@/components/FeaturesSection";
import Footer from "@/components/Footer";

const Index = () => {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <HeroSection />
      <GamesSection />
      <LeaderboardSection />
      <FeaturesSection />
      <Footer />
    </div>
  );
};

export default Index;
