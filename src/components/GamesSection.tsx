import { useState } from "react";
import { ArrowRight, Star, Clock, Flame, TrendingUp, X } from "lucide-react";

import casinoImg from "@/assets/casino-card.jpg";
import coinflipImg from "@/assets/coinflip-card.jpg";
import diceImg from "@/assets/dice-card.jpg";
import wheelImg from "@/assets/wheel-card.jpg";
import hiloImg from "@/assets/hilo-card.png";
import minesImg from "@/assets/mines-card.png";
import rpsImg from "@/assets/rps-card.png";

interface Game {
  image: string;
  title: string;
}

interface GameRowProps {
  icon: React.ReactNode;
  title: string;
  subtitle: string;
  games: Game[];
  onViewAll: () => void;
}

const GameRow = ({ icon, title, subtitle, games, onViewAll }: GameRowProps) => (
  <div className="glass rounded-xl p-4 mb-4">
    <div className="flex items-center justify-between mb-3">
      <div className="flex items-center gap-3">
        <div className="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
          {icon}
        </div>
        <div>
          <h3 className="text-foreground font-semibold">{title}</h3>
          <p className="text-muted-foreground text-xs">{subtitle}</p>
        </div>
      </div>
      <button
        onClick={onViewAll}
        className="p-2 text-muted-foreground hover:text-foreground transition-colors"
      >
        <ArrowRight className="w-5 h-5" />
      </button>
    </div>
    <div className="flex gap-3 overflow-x-auto pb-1">
      {games.map((game) => (
        <div key={game.title} className="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 border border-border cursor-pointer transition-transform duration-300 hover:scale-150 hover:z-10">
          <img src={game.image} alt={game.title} className="w-full h-full object-cover" />
        </div>
      ))}
    </div>
  </div>
);

interface LibraryModalProps {
  title: string;
  games: Game[];
  onClose: () => void;
}

const LibraryModal = ({ title, games, onClose }: LibraryModalProps) => (
  <>
    <div className="fixed inset-0 bg-black/60 z-[200]" onClick={onClose} />
    <div className="fixed inset-4 md:inset-16 z-[201] bg-card border border-border rounded-2xl overflow-auto p-6">
      <div className="flex items-center justify-between mb-6">
        <h2 className="font-display text-xl md:text-2xl font-bold text-foreground">{title}</h2>
        <button onClick={onClose} className="p-2 text-muted-foreground hover:text-foreground transition-colors">
          <X className="w-5 h-5" />
        </button>
      </div>
      <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        {games.map((game) => (
          <div
            key={game.title}
            className="glass rounded-xl p-3 flex flex-col items-center gap-2 cursor-pointer hover:bg-[hsl(var(--surface-glass-hover))] transition-colors"
          >
            <div className="w-20 h-20 rounded-lg overflow-hidden border border-border">
              <img src={game.image} alt={game.title} className="w-full h-full object-cover" />
            </div>
            <span className="text-foreground text-sm font-medium text-center">{game.title}</span>
          </div>
        ))}
      </div>
    </div>
  </>
);

const allGames = [
  { image: diceImg, title: "Dice" },
  { image: coinflipImg, title: "Flip" },
  { image: hiloImg, title: "Hilo" },
  { image: minesImg, title: "Mines" },
  { image: casinoImg, title: "Roulette" },
  { image: rpsImg, title: "Rock Paper Scissors" },
  { image: wheelImg, title: "Wheel" },
];

const categories = [
  { icon: <Star className="w-5 h-5 text-primary" />, title: "Favorited Games", subtitle: "4 games", games: allGames.slice(0, 4) },
  { icon: <Clock className="w-5 h-5 text-primary" />, title: "Frequently Played", subtitle: "889 total plays", games: allGames.slice(1, 5) },
  { icon: <Flame className="w-5 h-5 text-primary" />, title: "Popular Games", subtitle: "Top rated by players", games: allGames.slice(0, 4) },
  { icon: <TrendingUp className="w-5 h-5 text-primary" />, title: "Trending", subtitle: "2 games trending now", games: allGames.slice(3, 7) },
];

const GamesSection = () => {
  const [openCategory, setOpenCategory] = useState<number | null>(null);

  return (
    <section className="py-12">
      <div className="container mx-auto px-4 max-w-2xl">
        <h2 className="font-display text-2xl md:text-3xl font-bold tracking-tight mb-6 text-center">
          <span className="text-foreground">Browse Collections</span>
        </h2>
        {categories.map((cat, i) => (
          <GameRow
            key={cat.title}
            icon={cat.icon}
            title={cat.title}
            subtitle={cat.subtitle}
            games={cat.games}
            onViewAll={() => setOpenCategory(i)}
          />
        ))}
      </div>

      {openCategory !== null && (
        <LibraryModal
          title={categories[openCategory].title}
          games={categories[openCategory].games}
          onClose={() => setOpenCategory(null)}
        />
      )}
    </section>
  );
};

export default GamesSection;
